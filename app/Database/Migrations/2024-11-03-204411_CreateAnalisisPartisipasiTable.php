<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisPartisipasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_subjek'      => ['type' => 'BIGINT', 'unsigned' => true],
            'id_master'      => ['type' => 'INT', 'unsigned' => true],
            'id_periode'     => ['type' => 'INT', 'unsigned' => true],
            'id_klassifikasi' => ['type' => 'INT', 'unsigned' => true],
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_partisipasi');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_partisipasi');
    }
}
