<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramSumberDana extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sumber_dana' => [
                'type'       => 'VARCHAR',
                'constraint' => 31,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('program_sumber_dana');
    }

    public function down()
    {
        $this->forge->dropTable('program_sumber_dana');
    }
}
