<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKomentarTable extends Migration
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
            'id_artikel' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'owner' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'komentar' => [
                'type' => 'TEXT',
            ],
            'tgl_upload' => [
                'type' => 'TIMESTAMP',
            ],
            'enabled' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('komentar');
    }

    public function down()
    {
        $this->forge->dropTable('komentar');
    }
}
