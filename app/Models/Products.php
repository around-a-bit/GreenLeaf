<?php

namespace App\Models;

use CodeIgniter\Model;

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
}
