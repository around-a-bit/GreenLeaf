<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayoutsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'shop_id' => ['type' => 'INT'],
            'amount' => ['type' => 'DECIMAL','constraint' => '10,2'],
            'status' => ['type' => 'VARCHAR','constraint' => 50],
            'requested_at' => ['type' => 'DATETIME','null' => true],
            'paid_at' => ['type' => 'DATETIME','null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payouts');
    }

    public function down()
    {
        $this->forge->dropTable('payouts');
    }
}
