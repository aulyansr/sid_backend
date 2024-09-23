<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukSexTable extends Migration
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
                'constraint' => 15,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_sex');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_sex');
    }
}
