<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserGrupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 3,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_grup');
    }

    public function down()
    {
        $this->forge->dropTable('user_grup');
    }
}
