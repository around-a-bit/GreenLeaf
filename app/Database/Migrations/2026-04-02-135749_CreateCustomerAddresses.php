<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerAddresses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'type' => [
                'type' => 'ENUM',
                'constraint' => ['home', 'office', 'other'],
                'default' => 'home'
            ],

            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true // optional: delivery person name
            ],

            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true // optional: delivery contact
            ],

            'address_line1' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'address_line2' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'landmark' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true
            ],

            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'India'
            ],

            'pincode' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],

            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
            ],

            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
            ],

            'is_default' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],

            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1, // 1 active, 0 deleted/hidden
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // 🔑 Primary Key
        $this->forge->addKey('id', true);

        // ⚡ Index for performance
        $this->forge->addKey('user_id');

        // 🔗 Foreign Key
        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // 🚀 Create Table
        $this->forge->createTable('customer_addresses', true, [
            'ENGINE' => 'InnoDB',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('customer_addresses');
    }
}