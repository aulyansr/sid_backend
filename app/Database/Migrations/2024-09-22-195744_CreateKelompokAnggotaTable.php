<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelompokAnggotaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'id_kelompok'   => ['type' => 'INT'],
            'id_penduduk'   => ['type' => 'BIGINT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kelompok_anggota');
    }

    public function down()
    {
        $this->forge->dropTable('kelompok_anggota');
    }
}
