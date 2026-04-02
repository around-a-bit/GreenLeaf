<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Products;
use App\Models\ProductImages;

class CartItems extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
        protected $allowedFields = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];



    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getCart($userId)
{
    $productModel = new Products();
    $imageModel   = new ProductImages();

    $productsTable = $productModel->table;
    $imagesTable   = $imageModel->table;

    return $this
        ->select("
            cart_items.*,
            {$productsTable}.name,
            MIN({$imagesTable}.image_path) as image
        ")
        ->join($productsTable, "{$productsTable}.id = cart_items.product_id")
        ->join($imagesTable, "{$imagesTable}.product_id = {$productsTable}.id", 'left')
        ->where('cart_items.user_id', $userId)
        ->groupBy('cart_items.id')
        ->findAll();
}
}
