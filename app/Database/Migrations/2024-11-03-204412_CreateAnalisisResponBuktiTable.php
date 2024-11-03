<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisResponBuktiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'  => ['type' => 'INT', 'unsigned' => true],
            'id_periode' => ['type' => 'INT', 'unsigned' => true],
            'id_subjek'  => ['type' => 'BIGINT', 'unsigned' => true],
            'pengesahan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'tgl_update' => ['type' => 'TIMESTAMP'],
        ]);
        $this->forge->createTable('analisis_respon_bukti');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_respon_bukti');
    }
}
