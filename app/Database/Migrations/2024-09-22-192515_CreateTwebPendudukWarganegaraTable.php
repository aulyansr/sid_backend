<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukWarganegaraTable extends Migration
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
                'constraint' => 25,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_warganegara');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_warganegara');
    }
}
