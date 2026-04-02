<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true,'auto_increment' => true],
            'shop_id' => ['type' => 'INT'],
            'category_id' => ['type' => 'INT'],
            'name' => ['type' => 'VARCHAR','constraint' => 150],
            'description' => ['type' => 'TEXT'],
            'price' => ['type' => 'DECIMAL','constraint' => '10,2'],
            'discount_price' => ['type' => 'DECIMAL','constraint' => '10,2','null' => true],
            'stock' => ['type' => 'INT'],
            'is_active' => ['type' => 'TINYINT','default' => 1],
            'status' => ['type' => 'TINYINT','default' => 0],
            'deleted_at' => ['type' => 'DATETIME','null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
