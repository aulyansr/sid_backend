<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'urut' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
            'enabled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'parrent' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
