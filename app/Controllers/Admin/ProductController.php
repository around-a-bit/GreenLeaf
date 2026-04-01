<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Products;
use App\Models\ProductImages;

class ProductController extends BaseController
{
    // public function index()
    // {
    //     $model = new Products();

    //     $products = $model
    //         ->select('products.*, categories.name as category')
    //         ->join('categories', 'categories.id = products.category_id', 'left')
    //         ->findAll();

    //     return view('admin/products/index', compact('products'));
    // }

public function index()
{
    $productModel = new Products();
    $imageModel   = new ProductImages();

    $products = $productModel
        ->withCategory()
        ->orderBy('id', 'DESC') 
        ->findAll();
        
    foreach ($products as &$p) {
        $p['images'] = $imageModel
            ->where('product_id', $p['id'])
            ->findAll();
    }
    return view('admin/products/index', compact('products'));
}

public function updateStatus()
{
    $model = new Products();
    $db = \Config\Database::connect();

    try {
        $db->transBegin();

        $id = (int) $this->request->getPost('id');
        $status = (int) $this->request->getPost('status'); // ✅ cast

        // 🔒 Validate status
        if (!in_array($status, [0, 1, 2], true)) {
            log_message('error', 'Invalid status value: ' . $status);
            return redirect()->back()->with('error', 'Invalid status');
        }

        // 🔍 Fetch product
        $product = $model->find($id);

        if (!$product) {
            log_message('error', 'Product not found: ID ' . $id);
            return redirect()->back()->with('error', 'Product not found');
        }

        // 🚫 No change
        if ((int)$product['status'] === $status) {
            return redirect()->back()->with('msg', 'No changes made');
        }

        // ✅ Update
        $model->update($id, ['status' => $status]);

        // 🔥 Log admin action
        log_message(
            'info',
            'Admin ID: ' . session('admin_id') .
            ' updated product ID: ' . $id .
            ' to status: ' . $status
        );

        // ✅ Commit
        if ($db->transStatus() === false) {
            throw new \Exception('Transaction failed');
        }

        $db->transCommit();

        return redirect()->back()->with('msg', 'Status updated successfully');

    } catch (\Throwable $e) {

        // ❌ Rollback
        $db->transRollback();

        log_message('error', 'Product status update failed: ' . $e->getMessage());
        log_message('error', 'Trace: ' . $e->getTraceAsString());

        return redirect()->back()->with('error', 'Something went wrong');
    }
}
}