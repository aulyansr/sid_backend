<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisIndikatorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'    => ['type' => 'INT', 'unsigned' => true],
            'nomor'        => ['type' => 'INT', 'unsigned' => true],
            'pertanyaan'   => ['type' => 'VARCHAR', 'constraint' => 400],
            'id_tipe'      => ['type' => 'TINYINT', 'unsigned' => true],
            'bobot'        => ['type' => 'TINYINT', 'unsigned' => true],
            'act_analisis' => ['type' => 'TINYINT', 'constraint' => 1],
            'id_kategori'  => ['type' => 'INT', 'unsigned' => true],
            'is_publik'    => ['type' => 'TINYINT', 'constraint' => 1],
            'is_statistik' => ['type' => 'INT', 'unsigned' => true],
            'is_required'  => ['type' => 'TINYINT', 'constraint' => 1],
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_indikator');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_indikator');
    }
}
