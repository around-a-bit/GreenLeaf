<?php

namespace App\Models;

use CodeIgniter\Model;

class ShopOwners extends Model
{
    protected $table            = 'shop_owners';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
    'name',
    'email',
    'password',
    'role',
    'status',
    'created_at'
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

    // 🔐 Find by email (used in login) 
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    // ✅ Active shop owners only 
    public function getActiveOwners()
    {
        return $this->where('status', 1)->findAll();
    } // 🔒 Check login credentials 
    public function verifyLogin($email, $password)
    {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
