<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToAdmins extends Migration
{
    public function up()
    {
        $this->forge->addColumn('admins', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['super_admin', 'sub_admin'],
                'default' => 'sub_admin',
                'after' => 'password',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'after' => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('admins', ['role', 'status']);
    }
}