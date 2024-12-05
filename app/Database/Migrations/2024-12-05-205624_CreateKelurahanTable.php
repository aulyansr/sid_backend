<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelurahanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_kel' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'nama_kelurahan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_kec' => [
                'type' => 'INT',
                'constraint' => 4,
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
        $this->forge->createTable('kelurahan');
    }

    public function down()
    {
        $this->forge->dropTable('kelurahan');
    }
}
