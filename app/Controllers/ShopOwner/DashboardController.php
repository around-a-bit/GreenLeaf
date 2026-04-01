<?php

namespace App\Controllers\ShopOwner;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = $this->getShopData();

        return view('ShopOwner/dashboard/index', $data);
    }
}