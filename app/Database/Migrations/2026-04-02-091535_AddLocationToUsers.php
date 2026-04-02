<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLocationToUsers extends Migration
{
public function up()
{
    $this->forge->addColumn('users', [
        'lat' => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
        'lng' => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
        'address' => ['type' => 'TEXT', 'null' => true],
    ]);
}

public function down()
{
    $this->forge->dropColumn('users', ['lat', 'lng', 'address']);
}
}
