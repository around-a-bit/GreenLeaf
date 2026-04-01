<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToProducts extends Migration
{
    public function up()
    {
        $fields = [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at' // optional (keeps structure clean)
            ]
        ];

        $this->forge->addColumn('products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'updated_at');
    }
}