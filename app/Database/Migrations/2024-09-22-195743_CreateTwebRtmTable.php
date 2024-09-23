<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebRtmTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'auto_increment' => true],
            'nik_kepala'  => ['type' => 'BIGINT'],
            'no_kk'       => ['type' => 'BIGINT'],
            'tgl_daftar'  => ['type' => 'TIMESTAMP'],
            'kelas_sosial' => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_rtm');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_rtm');
    }
}
