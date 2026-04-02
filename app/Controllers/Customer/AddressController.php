<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CustomerAddresses;

class AddressController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CustomerAddresses();
    }

    // 📄 LIST ALL ADDRESSES
    public function index()
    {
        $userId = session('id');

        $addresses = $this->model
            ->where('user_id', $userId)
            ->where('status', 1)
            ->orderBy('is_default', 'DESC')
            ->findAll();

        return view('customer/address/index', [
            'addresses' => $addresses
        ]);
    }

    // ➕ CREATE PAGE
    public function create()
    {
        return view('customer/address/create');
    }

    // 💾 STORE ADDRESS
    public function store()
    {
        $userId = session('id');

        $data = $this->request->getPost();

        // 🔐 Attach user
        $data['user_id'] = $userId;

        // ⚡ Validation (basic)
        if (!$this->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Validation failed');
        }

        // 🔥 Ensure only ONE default address
        if (!empty($data['is_default'])) {
            $this->model->where('user_id', $userId)
                ->set(['is_default' => 0])
                ->update();
        }

        // Insert
        $this->model->insert($data);

        return redirect()->to('/customer/address')
            ->with('success', 'Address added successfully');
    }

    // ✏️ EDIT PAGE
    public function edit($id)
    {
        $userId = session('id');

        $address = $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Address not found');
        }

        return view('customer/address/edit', [
            'address' => $address
        ]);
    }

    // 🔄 UPDATE ADDRESS
    public function update($id)
    {
        $userId = session('id');

        $address = $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $data = $this->request->getPost();

        // ⚡ Validation
        if (!$this->validate([
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Validation failed');
        }

        // 🔥 Handle default logic
        if (!empty($data['is_default'])) {
            $this->model->where('user_id', $userId)
                ->set(['is_default' => 0])
                ->update();
        }

        $this->model->update($id, $data);

        return redirect()->to('/customer/address')
            ->with('success', 'Address updated successfully');
    }

    // ❌ SOFT DELETE
    public function delete($id)
    {
        $userId = session('id');

        $address = $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $this->model->update($id, [
            'status' => 0,
            'is_default' => 0
        ]);

        return redirect()->back()->with('success', 'Address deleted');
    }

    // ⭐ SET DEFAULT ADDRESS
    public function setDefault($id)
    {
        $userId = session('id');

        $address = $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        // Reset all
        $this->model->where('user_id', $userId)
            ->set(['is_default' => 0])
            ->update();

        // Set selected
        $this->model->update($id, [
            'is_default' => 1
        ]);

        return redirect()->back()->with('success', 'Default address updated');
    }
}