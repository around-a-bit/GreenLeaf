<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShopOwnersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'name' => ['type' => 'VARCHAR','constraint' => 100],
            'email' => ['type' => 'VARCHAR','constraint' => 150],
            'password' => ['type' => 'VARCHAR','constraint' => 255],
            'status' => ['type' => 'TINYINT','default' => 1],
            'created_at' => ['type' => 'DATETIME','null' => true]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('shop_owners');
    }

    public function down()
    {
        $this->forge->dropTable('shop_owners');
    }
}
