<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelompokTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'id_master'  => ['type' => 'INT'],
            'id_ketua'   => ['type' => 'BIGINT'],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 16],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kelompok');
    }

    public function down()
    {
        $this->forge->dropTable('kelompok');
    }
}
