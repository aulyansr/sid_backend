<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisResponHasilTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'  => ['type' => 'INT', 'unsigned' => true],
            'id_periode' => ['type' => 'INT', 'unsigned' => true],
            'id_subjek'  => ['type' => 'BIGINT', 'unsigned' => true],
            'akumulasi'  => ['type' => 'DOUBLE PRECISION', 'null' => false],
            'tgl_update' => ['type' => 'TIMESTAMP', 'default' => 'now()', 'null' => false],  // Use now() for PostgreSQL
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_respon_hasil');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_respon_hasil');
    }
}
