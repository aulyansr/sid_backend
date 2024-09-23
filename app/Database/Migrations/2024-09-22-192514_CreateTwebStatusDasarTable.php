<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebStatusDasarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_status_dasar');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_status_dasar');
    }
}
