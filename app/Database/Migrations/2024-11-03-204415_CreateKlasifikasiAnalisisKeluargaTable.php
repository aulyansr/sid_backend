<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlasifikasiAnalisisKeluargaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nama'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'jenis' => ['type' => 'INT', 'unsigned' => true],
            'id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('klasifikasi_analisis_keluarga');
    }

    public function down()
    {
        $this->forge->dropTable('klasifikasi_analisis_keluarga');
    }
}
