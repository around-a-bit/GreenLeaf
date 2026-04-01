<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','auto_increment' => true],
            'user_id' => ['type' => 'INT'],
            'role' => ['type' => 'VARCHAR','constraint' => 50],
            'subject' => ['type' => 'VARCHAR','constraint' => 255],
            'status' => ['type' => 'VARCHAR','constraint' => 50],
            'created_at' => ['type' => 'DATETIME','null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
