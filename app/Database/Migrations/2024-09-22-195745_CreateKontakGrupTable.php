<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKontakGrupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nama_grup'  => ['type' => 'VARCHAR', 'constraint' => 30],
            'id_kontak'  => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontak_grup');
    }

    public function down()
    {
        $this->forge->dropTable('kontak_grup');
    }
}
