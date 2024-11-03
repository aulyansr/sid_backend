<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisResponTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_indikator'   => ['type' => 'INT', 'unsigned' => true],
            'id_parameter'   => ['type' => 'INT', 'unsigned' => true],
            'id_subjek'      => ['type' => 'BIGINT', 'unsigned' => true],
            'id_periode'     => ['type' => 'INT', 'unsigned' => true],
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_respon');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_respon');
    }
}
