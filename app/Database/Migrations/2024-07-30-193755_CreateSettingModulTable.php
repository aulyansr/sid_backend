<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingModulTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'modul' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '256'
            ],
            'aktif' => [
                'type' => 'TINYINT',
                'constraint' => '1'
            ],
            'ikon' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'urut' => [
                'type' => 'TINYINT',
                'constraint' => '3'
            ],
            'level' => [
                'type' => 'TINYINT',
                'constraint' => '1'
            ],
            'hidden' => [
                'type' => 'TINYINT',
                'constraint' => '1'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('setting_modul');
    }

    public function down()
    {
        $this->forge->dropTable('setting_modul');
    }
}
