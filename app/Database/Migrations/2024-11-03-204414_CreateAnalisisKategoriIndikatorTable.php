<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisKategoriIndikatorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'     => ['type' => 'INT', 'unsigned' => true],
            'kategori_kode' => ['type' => 'VARCHAR', 'constraint' => 3],
            'kategori'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_kategori_indikator');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_kategori_indikator');
    }
}
