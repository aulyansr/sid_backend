<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramTable extends Migration
{
    public function up()
    {
        // Membuat tabel 'program'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'ndesc' => [
                'type' => 'TEXT',
            ],
            'sasaran' => [
                'type' => 'TINYINT',
                'constraint' => '1',
            ],
            'sdate' => [
                'type' => 'DATETIME',
            ],
            'edate' => [
                'type' => 'DATETIME',
            ],
            'userID' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rdate' => [
                'type' => 'TIMESTAMP',
                'default' => 'now()',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => '1',
            ],
            'pelaksana' => [
                'type'       => 'VARCHAR',
                'constraint' => '31',
            ],
            'id_sumber_dana' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('program');
    }

    public function down()
    {
        // Drop table 'program'
        $this->forge->dropTable('program');
    }
}
