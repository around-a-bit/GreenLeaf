<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders', [

            'address_id' => [
                'type' => 'INT',
                'after' => 'customer_id',
                'null' => true
            ],

            'payment_method' => [
                'type' => 'ENUM',
                'constraint' => ['stripe', 'cod'],
                'after' => 'net_amount',
                'null' => true
            ],

            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid'],
                'default' => 'pending',
                'after' => 'payment_method'
            ]

        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', [
            'address_id',
            'payment_method',
            'payment_status'
        ]);
    }
}