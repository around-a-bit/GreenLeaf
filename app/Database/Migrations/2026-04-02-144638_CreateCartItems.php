<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartItems extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],

            'user_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],

            'product_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],

            'quantity' => [
                'type' => 'INT',
                'default' => 1
            ],

            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],

        ]);

        $this->forge->addKey('id', true);

        // ⚡ Unique constraint
        $this->forge->addUniqueKey(['user_id', 'product_id']);

        // ❗ ADD FOREIGN KEYS AFTER CHECK
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('cart_items', true, [
            'ENGINE' => 'InnoDB' // 🔥 MUST ADD THIS
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('cart_items');
    }
}