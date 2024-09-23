<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebGolonganDarahTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_golongan_darah');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_golongan_darah');
    }
}
