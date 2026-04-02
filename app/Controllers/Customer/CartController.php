<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\CartItems;

class CartController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CartItems();
    }

    // 🛒 VIEW CART
    public function index()
    {
        $userId = session('id');

        if (!$userId) {
            return redirect()->to('/customer/login')
                ->with('error', 'Session expired. Please login again.');
        }

        $cart = $this->model->getCart($userId);

        return view('customer/cart/index', [
            'cart' => $cart
        ]);
    }

    // ➕ ADD TO CART
    public function add()
    {
        try {
            $userId = session('id');

            if (!$userId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not logged in',
                    'csrfToken' => csrf_hash()
                ]);
            }

            $productId = (int) $this->request->getPost('product_id');
            $qty = (int) $this->request->getPost('quantity');
            $price = (float) $this->request->getPost('price');

            if (!$productId || !$qty || !$price) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid input',
                    'csrfToken' => csrf_hash()
                ]);
            }

            $existing = $this->model
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                $this->model->update($existing['id'], [
                    'quantity' => $existing['quantity'] + $qty
                ]);
            } else {
                $this->model->insert([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'csrfToken' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
                'csrfToken' => csrf_hash()
            ]);
        }
    }

    public function remove($id)
    {
        try {
            $this->model->delete($id);

            return redirect()->back()->with('success', 'Item removed');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove item');
        }
    }
    public function update()
    {
        try {
            $id = (int) $this->request->getPost('id');
            $qty = (int) $this->request->getPost('quantity');

            if (!$id || !$qty) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'csrfToken' => csrf_hash()
                ]);
            }

            $this->model->update($id, [
                'quantity' => $qty
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'csrfToken' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'csrfToken' => csrf_hash()
            ]);
        }
    }
}
