<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelompokMasterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'kelompok'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi'  => ['type' => 'VARCHAR', 'constraint' => 400],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kelompok_master');
    }

    public function down()
    {
        $this->forge->dropTable('kelompok_master');
    }
}
