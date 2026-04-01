<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'shop_id' => ['type' => 'INT'],
            'customer_id' => ['type' => 'INT'],
            'total_amount' => ['type' => 'DECIMAL','constraint' => '10,2'],
            'commission_amount' => ['type' => 'DECIMAL','constraint' => '10,2'],
            'net_amount' => ['type' => 'DECIMAL','constraint' => '10,2'],
            'status' => ['type' => 'VARCHAR','constraint' => 50],
            'created_at' => ['type' => 'DATETIME','null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
