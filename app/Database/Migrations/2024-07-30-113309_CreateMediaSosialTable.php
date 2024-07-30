<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaSosialTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'gambar' => [
                'type' => 'TEXT',
            ],
            'link' => [
                'type' => 'TEXT',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'enabled' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('media_sosial');
    }

    public function down()
    {
        $this->forge->dropTable('media_sosial');
    }
}
