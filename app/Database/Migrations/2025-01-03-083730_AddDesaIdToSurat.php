<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToSurat extends Migration
{
    public function up()
    {
        $fields = [
            'desa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,    // Allows NULL values
                'after'      => 'id',    // Adjust this to place the column after a specific field
            ],
        ];

        $this->forge->addColumn('surat', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('surat', 'desa_id');
    }
}
