<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllowNullInTwebKeluarga extends Migration
{
    public function up()
    {
        // Modify the existing table to allow NULL values for specified columns
        $this->forge->modifyColumn('tweb_keluarga', [
            'kelas_sosial' => ['type' => 'INT', 'null' => true], // Allow NULL
            'raskin' => ['type' => 'INT', 'null' => true], // Allow NULL
            'id_bedah_rumah' => ['type' => 'INT', 'null' => true], // Allow NULL
            'id_pkh' => ['type' => 'INT', 'null' => true], // Allow NULL
            'id_blt' => ['type' => 'INT', 'null' => true], // Allow NULL
        ]);
    }

    public function down()
    {
        // Revert the changes to NOT NULL
        $this->forge->modifyColumn('tweb_keluarga', [
            'kelas_sosial' => ['type' => 'INT', 'null' => false], // Revert to NOT NULL
            'raskin' => ['type' => 'INT', 'null' => false], // Revert to NOT NULL
            'id_bedah_rumah' => ['type' => 'INT', 'null' => false], // Revert to NOT NULL
            'id_pkh' => ['type' => 'INT', 'null' => false], // Revert to NOT NULL
            'id_blt' => ['type' => 'INT', 'null' => false], // Revert to NOT NULL
        ]);
    }
}
