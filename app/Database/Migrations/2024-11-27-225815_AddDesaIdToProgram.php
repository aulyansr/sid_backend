<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToProgram extends Migration
{
    public function up()
    {
        // Add the new column desa_id
        $this->forge->addColumn('program', [
            'desa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,    // Allow NULL
            ],
        ]);
    }

    public function down()
    {
        // Remove the desa_id column
        $this->forge->dropColumn('program', 'desa_id');
    }
}
