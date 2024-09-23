<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebSakitMenahunTable extends Migration
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
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_sakit_menahun');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_sakit_menahun');
    }
}
