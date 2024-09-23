<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukAgamaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_agama');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_agama');
    }
}
