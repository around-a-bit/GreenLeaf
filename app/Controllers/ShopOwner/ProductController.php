<?php

namespace App\Controllers\ShopOwner;

use App\Controllers\BaseController;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Shops;

class ProductController extends BaseController
{

// public function index()
// {
//     $model = new Products();
//     $db = \Config\Database::connect();

//     $shops = $db->table('shops')
//         ->where('owner_id', session('owner_id'))
//         ->get()
//         ->getResultArray();

//     $shopId = $this->request->getGet('shop_id');

//     if ($shopId) {
//         $products = $model->withImages()->forShop($shopId)->findAll();
//     } else {
//         $products = [];
//     }

//     return view('shopOwner/products/index', [
//         'products' => $products,
//         'shops'    => $shops,
//         'selectedShop' => $shopId
//     ]);
// }


public function index()
{
    $productModel = new Products();
    $shopModel = new Shops();

    $shops = $shopModel
        ->where('owner_id', session('user_id'))
        ->findAll();

    $shopId = $this->request->getGet('shop_id') ?? ($shops[0]['id'] ?? null);

    $products = [];

    if ($shopId) {

        $validShop = $shopModel
            ->where('id', $shopId)
            ->where('owner_id', session('user_id'))
            ->first();

        if ($validShop) {
            $products = $productModel
                ->withImages()
                ->forShop($shopId)
                ->findAll();
        }
    }

    return view('shopOwner/products/index', [
        'products'      => $products,
        'shops'         => $shops,
        'selectedShop'  => $shopId
    ]);
}

    // public function index()
    // {
    //     $model = new Products();

    //     $products = $model
    //         ->withImages()
    //         ->forShop(session('shop_id'))
    //         ->findAll();
    //     return view('shopOwner/products/index', [
    //         'products' => $products
    //     ]);
    // }



    public function create()
    {

        $shopsM = new Shops();
           $shops = $shopsM->where('owner_id', session('user_id'))
            ->findAll();

            
        $catModel = new Categories();
        $categories = $catModel->where('is_active', 1)->findAll();

        return view('shopOwner/products/create', [
            'categories' => $categories,
            'shops'      => $shops
        ]);
    }

public function store()
{
    $model = new Products();
    $db = \Config\Database::connect();

    try {
        // 🔥 Start transaction manually
        $db->transBegin();

        $shopId = $this->request->getPost('shop_id');

        // 🔍 Validate shop ownership
        $shop = $db->table('shops')
            ->where('id', $shopId)
            ->where('owner_id', session('user_id')) // ✅ FIXED
            ->get()
            ->getRowArray();

        if (!$shop) {
            log_message('error', 'Invalid shop access attempt. User: ' . session('user_id') . ' Shop: ' . $shopId);

            return redirect()->back()->with('error', 'Invalid shop selected');
        }

        // 📝 Save product
        $model->save([
            'shop_id'        => $shopId,
            'category_id'    => $this->request->getPost('category_id'),
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'price'          => $this->request->getPost('price'),
            'discount_price' => $this->request->getPost('discount_price'),
            'stock'          => $this->request->getPost('stock'),
            'status'         => 0,
            'is_active'      => 1
        ]);

        $productId = $model->getInsertID();

        log_message('info', 'Product created. ID: ' . $productId . ' by user: ' . session('user_id'));

        // 📸 Handle images
        $images = $this->request->getFiles();

        if (isset($images['images'])) {
            foreach ($images['images'] as $img) {

                if ($img->isValid() && !$img->hasMoved()) {

                    $newName = $img->getRandomName();

                    if (!is_dir('uploads/products')) {
                        mkdir('uploads/products', 0777, true);
                    }

                    $img->move('uploads/products', $newName);

                    $db->table('product_images')->insert([
                        'product_id' => $productId,
                        'image_path' => 'uploads/products/' . $newName
                    ]);

                    log_message('info', 'Image uploaded for product ID: ' . $productId);
                }
            }
        }

        // ✅ Commit transaction
        if ($db->transStatus() === false) {
            throw new \Exception('Transaction failed');
        }

        $db->transCommit();

        return redirect()->to('shop_owner/products')
            ->with('msg', 'Product + images submitted for approval');

    } catch (\Throwable $e) {

        // ❌ Rollback on error
        $db->transRollback();

        // 🧾 Log full error
        log_message('error', 'Product store failed: ' . $e->getMessage());
        log_message('error', 'Trace: ' . $e->getTraceAsString());

        return redirect()->back()
            ->with('error', 'Something went wrong. Please try again.');
    }
}
}
