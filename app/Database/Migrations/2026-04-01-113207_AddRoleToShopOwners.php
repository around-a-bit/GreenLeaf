<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToShopOwners extends Migration
{
    public function up()
    {
        $this->forge->addColumn('shop_owners', [
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'shop_owner',
                'after' => 'password'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('shop_owners', 'role');
    }
}