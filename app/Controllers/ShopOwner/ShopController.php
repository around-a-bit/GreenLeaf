<?php

namespace App\Controllers\ShopOwner;

use App\Controllers\BaseController;
use App\Models\ShopOwners;
use App\Models\Shops;

class ShopController extends BaseController
{
    private function checkOwnerApproval()
    {
        $model = new ShopOwners();
        $owner = $model->find(session('user_id'));

        if (!$owner) {
            return redirect()->to('/shopOwner/login')
                ->with('error', 'Session expired');
        }

        // 🔥 sync session (VERY IMPORTANT)
        session()->set('status', $owner['status']);

        if ($owner['status'] != 1) {
            return redirect()->to('shop_owner/dashboard')
                ->with('error', 'Your account is not approved by admin');
        }

        return null;
    }

    public function index()
    {
        if ($res = $this->checkOwnerApproval()) return $res;

        $shopModel = new Shops();
        $shops = $shopModel->where('owner_id', session('user_id'))->findAll();

        return view('ShopOwner/shop/index', ['shops' => $shops]);
    }

    public function create()
    {
        if ($res = $this->checkOwnerApproval()) return $res;

        return view('ShopOwner/shop/create');
    }

    public function store()
    {
        if ($res = $this->checkOwnerApproval()) return $res;

        $shopModel = new Shops();

        $shopModel->insert([
            'owner_id'   => session('user_id'),
            'shop_name'  => $this->request->getPost('shop_name'),
            'tagline'    => $this->request->getPost('tagline'),
            'description'=> $this->request->getPost('description'),
            'lat'        => $this->request->getPost('lat'),
            'lng'        => $this->request->getPost('lng'),
            'address'    => $this->request->getPost('address'),
            'status'     => 1 // shop verification step is not included yet thus keeping 1 initially.
        ]);

        return redirect()->to('/shop_owner/dashboard')
            ->with('success', 'Shop submitted for approval');
    }

    public function edit($id)
    {
        if ($res = $this->checkOwnerApproval()) return $res;

        $shopModel = new Shops();

        $shop = $shopModel
            ->where('id', $id)
            ->where('owner_id', session('user_id'))
            ->first();

        if (!$shop) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        return view('ShopOwner/shop/edit', ['shop' => $shop]);
    }

    public function update($id)
    {
        if ($res = $this->checkOwnerApproval()) return $res;

        $shopModel = new Shops();

        $shopModel->update($id, [
            'shop_name'  => $this->request->getPost('shop_name'),
            'tagline'    => $this->request->getPost('tagline'),
            'description'=> $this->request->getPost('description'),
        ]);

        return redirect()->to('/shop_owner/dashboard')
            ->with('success', 'Shop updated');
    }
}