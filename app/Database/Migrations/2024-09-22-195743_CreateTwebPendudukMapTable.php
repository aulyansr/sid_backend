<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukMapTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'  => ['type' => 'INT', 'auto_increment' => true],
            'lat' => ['type' => 'VARCHAR', 'constraint' => 24],
            'lng' => ['type' => 'VARCHAR', 'constraint' => 24],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_penduduk_map');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_map');
    }
}
