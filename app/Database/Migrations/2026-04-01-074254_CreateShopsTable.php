<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShopsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'owner_id' => ['type' => 'INT'],
            'shop_name' => ['type' => 'VARCHAR','constraint' => 150],
            'tagline' => ['type' => 'VARCHAR','constraint' => 255,'null' => true],
            'description' => ['type' => 'TEXT','null' => true],
            'logo' => ['type' => 'VARCHAR','constraint' => 255,'null' => true],
            'lat' => ['type' => 'DECIMAL','constraint' => '10,7'],
            'lng' => ['type' => 'DECIMAL','constraint' => '10,7'],
            'address' => ['type' => 'TEXT'],
            'status' => ['type' => 'TINYINT','default' => 0],
            'rejection_reason' => ['type' => 'TEXT','null' => true],
            'commission_rate' => ['type' => 'DECIMAL','constraint' => '5,2','default' => 10.00],
            'created_at' => ['type' => 'DATETIME','null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('shops');
    }

    public function down()
    {
        $this->forge->dropTable('shops');
    }
}
