<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisMasterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nama'            => ['type' => 'VARCHAR', 'constraint' => 40],
            'subjek_tipe'     => ['type' => 'TINYINT', 'unsigned' => true],
            'lock'            => ['type' => 'TINYINT', 'constraint' => 1],
            'fitur_prelist'   => ['type' => 'TINYINT', 'constraint' => 1],
            'deskripsi'       => ['type' => 'TEXT'],
            'kode_analisis'   => ['type' => 'VARCHAR', 'constraint' => 5],
            'id_child'        => ['type' => 'SMALLINT', 'unsigned' => true],
            'id_kelompok'     => ['type' => 'INT', 'unsigned' => true],
            'pembagi'         => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'fitur_pembobotan' => ['type' => 'TINYINT', 'constraint' => 1],
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_master');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_master');
    }
}
