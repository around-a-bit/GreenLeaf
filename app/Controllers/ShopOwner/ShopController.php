<?php

namespace App\Controllers\Shop;

use App\Controllers\BaseController;
use App\Models\Shops;

class ShopController extends BaseController
{
    public function index()
    {
        $shopModel = new Shops();

        $shop = $shopModel->where('owner_id', session('user_id'))->first();

        return view('shop/shop/index', ['shop' => $shop]);
    }

    public function create()
    {
        return view('shop/shop/create');
    }

    public function store()
    {
        $shopModel = new Shops();

        $shopModel->insert([
            'owner_id' => session('user_id'),
            'shop_name' => $this->request->getPost('shop_name'),
            'tagline' => $this->request->getPost('tagline'),
            'description' => $this->request->getPost('description'),
            'lat' => $this->request->getPost('lat'),
            'lng' => $this->request->getPost('lng'),
            'address' => $this->request->getPost('address'),
            'status' => 0 // pending
        ]);

        return redirect()->to('/shop/dashboard')
            ->with('success', 'Shop submitted for approval');
    }
}