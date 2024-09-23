<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebKeluargaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'auto_increment' => true],
            'no_kk'         => ['type' => 'BIGINT'],
            'nik_kepala'    => ['type' => 'BIGINT'],
            'tgl_daftar'    => ['type' => 'TIMESTAMP'],
            'kelas_sosial'  => ['type' => 'INT'],
            'raskin'        => ['type' => 'INT'],
            'id_bedah_rumah' => ['type' => 'INT'],
            'id_pkh'        => ['type' => 'INT'],
            'id_blt'        => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_keluarga');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_keluarga');
    }
}
