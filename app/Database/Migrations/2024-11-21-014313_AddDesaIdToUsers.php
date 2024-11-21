<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToUsers extends Migration
{
    public function up()
    {
        // Add desa_id to the users table
        $this->forge->addColumn('users', [
            'desa_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,    // If it's not required for all users
            ],
        ]);

        // Add a foreign key constraint for desa_id (assuming the desa table exists)
        $this->forge->addForeignKey('desa_id', 'desa', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the foreign key first
        $this->forge->dropForeignKey('users', 'users_desa_id_foreign');

        // Drop the column
        $this->forge->dropColumn('users', 'desa_id');
    }
}
