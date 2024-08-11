<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'jenis_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'keperluan' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('surat');
    }

    public function down()
    {
        $this->forge->dropTable('surat');
    }
}
