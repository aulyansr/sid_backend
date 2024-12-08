<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_kecamatan' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'nama_kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_kab' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'no_prop' => [
                'type' => 'INT',
                'constraint' => 4,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
