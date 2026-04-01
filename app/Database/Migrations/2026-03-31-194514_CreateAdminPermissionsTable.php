<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminPermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'admin_id' => [
                'type' => 'INT',
            ],
            'menu_key' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'can_view' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'can_create' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'can_update' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'can_delete' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('admin_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('admin_permissions');
    }
}