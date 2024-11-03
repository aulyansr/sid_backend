<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisPrelistTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master'        => ['type' => 'INT', 'unsigned' => true],
            'id_periode'       => ['type' => 'INT', 'unsigned' => true],
            'id_subjek'        => ['type' => 'BIGINT', 'unsigned' => true],
            'id_kode_prelist'  => ['type' => 'INT', 'unsigned' => true],
            'tgl_update'       => ['type' => 'TIMESTAMP', 'default' => 'now()', 'null' => false],  // Use now() for default
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_prelist');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_prelist');
    }
}
