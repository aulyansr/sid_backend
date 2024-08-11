<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNomorSuratToSurat extends Migration
{
    public function up()
    {
        // Add new column 'nomor_surat' to the 'surat' table
        $this->forge->addColumn('surat', [
            'nomor_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true, // or set to false if you want it to be not null
            ],
        ]);
    }

    public function down()
    {
        // Drop the 'nomor_surat' column from the 'surat' table
        $this->forge->dropColumn('surat', 'nomor_surat');
    }
}
