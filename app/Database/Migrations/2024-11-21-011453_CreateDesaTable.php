<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDesaTable extends Migration
{
    public function up()
    {
        // Create the 'desa' table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'permalink' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('desa');
    }

    public function down()
    {
        // Drop the 'desa' table
        $this->forge->dropTable('desa');
    }
}
