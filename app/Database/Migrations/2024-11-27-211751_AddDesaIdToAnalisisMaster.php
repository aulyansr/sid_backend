<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToAnalisisMaster extends Migration
{
    public function up()
    {
        // Add the new column desa_id
        $this->forge->addColumn('analisis_master', [
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
        $this->forge->dropColumn('analisis_master', 'desa_id');
    }
}
