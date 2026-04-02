<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Shops;
use App\Models\ProductImages;

class Products extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'shop_id',
        'category_id',
        'name',
        'description',
        'price',
        'discount_price',
        'stock',
        'is_active',
        'status'
    ];


    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
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
    protected $beforeInsert = ['setPendingStatus'];
    protected $beforeUpdate = ['setPendingOnUpdate'];
    protected $afterInsert    = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public const STATUS_PENDING  = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    protected function setPendingOnUpdate(array $data)
{
    // ❌ skip if admin is updating
    if (isset($data['data']['status'])) {
        return $data;
    }

    $data['data']['status'] = self::STATUS_PENDING;
    return $data;
}

    protected function setPendingStatus(array $data)
    {
        $data['data']['status'] = self::STATUS_PENDING;
        return $data;
    }


    public function approved()
    {
        return $this->where('status', self::STATUS_APPROVED);
    }

    public function pending()
    {
        return $this->where('status', self::STATUS_PENDING);
    }

    public function rejected()
    {
        return $this->where('status', self::STATUS_REJECTED);
    }
    


    public function withCategory()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');
    }
    public function withImages()
    {
        return $this->select('products.*, product_images.image_path')
            ->join('product_images', 'product_images.product_id = products.id', 'left')
            ->groupBy('products.id');
    }
    public function forShop($shopId)
{
    return $this->where('shop_id', $shopId);
}

    public function visible()
    {
        return $this->where('status', self::STATUS_APPROVED)
            ->where('is_active', 1);
    }


public function getNearby($lat, $lng)
{
    $shopsModel  = new Shops();
    $imagesModel = new ProductImages();

    $shopsTable  = $shopsModel->table;
    $imagesTable = $imagesModel->table;
    $productsTable = $this->table;

    return $this->select("
            {$productsTable}.*,
            {$shopsTable}.shop_name,
            {$shopsTable}.lat as shop_lat,
            {$shopsTable}.lng as shop_lng,
            {$imagesTable}.image_path as image,

            (6371 * acos(
                cos(radians($lat)) * cos(radians({$shopsTable}.lat)) *
                cos(radians({$shopsTable}.lng) - radians($lng)) +
                sin(radians($lat)) * sin(radians({$shopsTable}.lat))
            )) AS distance
        ")
        ->join($shopsTable, "{$shopsTable}.id = {$productsTable}.shop_id")
        ->join($imagesTable, "{$imagesTable}.product_id = {$productsTable}.id", 'left')

        ->where("{$productsTable}.status", self::STATUS_APPROVED)
        ->where("{$productsTable}.is_active", 1)

        ->where("{$shopsTable}.lat IS NOT NULL")
        ->where("{$shopsTable}.lng IS NOT NULL")

        ->having('distance <', 50)
        ->orderBy('distance', 'ASC')
        ->groupBy("{$productsTable}.id")

        ->findAll();
}
}
