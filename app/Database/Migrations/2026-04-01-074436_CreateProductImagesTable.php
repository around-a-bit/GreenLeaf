<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'product_id' => ['type' => 'INT'],
            'image_path' => ['type' => 'VARCHAR','constraint' => 255]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('product_images');
    }

    public function down()
    {
        $this->forge->dropTable('product_images');
    }
}
