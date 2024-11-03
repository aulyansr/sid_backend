<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisParameterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_indikator'  => ['type' => 'INT', 'unsigned' => true],
            'kode_jawaban'  => ['type' => 'INT', 'unsigned' => true],
            'asign'         => ['type' => 'TINYINT', 'constraint' => 1],
            'jawaban'       => ['type' => 'VARCHAR', 'constraint' => 200],
            'nilai'         => ['type' => 'INT', 'unsigned' => true],
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_parameter');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_parameter');
    }
}
