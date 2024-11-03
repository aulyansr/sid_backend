<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisPeriodeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'         => ['type' => 'INT', 'unsigned' => true],
            'nama'              => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_state'          => ['type' => 'TINYINT', 'unsigned' => true],
            'aktif'             => ['type' => 'TINYINT', 'constraint' => 1],
            'keterangan'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'tahun_pelaksanaan' => ['type' => 'SMALLINT'],
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_periode');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_periode');
    }
}
