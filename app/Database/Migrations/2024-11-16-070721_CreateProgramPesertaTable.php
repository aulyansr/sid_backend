<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramPesertaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'program_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'peserta'     => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'null'       => false,
            ],
            'sasaran'     => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
            ],
            'userID'      => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'rdate'    => [
                'type'    => 'TIMESTAMP',
                'default' => 'now()',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('program_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('program_peserta');
    }
}
