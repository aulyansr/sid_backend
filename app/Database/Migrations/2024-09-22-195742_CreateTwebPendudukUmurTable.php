<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukUmurTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'     => ['type' => 'INT', 'auto_increment' => true],
            'nama'   => ['type' => 'VARCHAR', 'constraint' => 25],
            'dari'   => ['type' => 'INT'],
            'sampai' => ['type' => 'INT'],
            'status' => ['type' => 'INT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_umur');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_umur');
    }
}
