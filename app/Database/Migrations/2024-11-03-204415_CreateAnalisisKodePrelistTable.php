<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisKodePrelistTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'      => ['type' => 'INT', 'unsigned' => true],
            'prelist_kode'   => ['type' => 'VARCHAR', 'constraint' => 3],
            'prelist_nama'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'prelist_masuk'  => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_kode_prelist');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_kode_prelist');
    }
}
