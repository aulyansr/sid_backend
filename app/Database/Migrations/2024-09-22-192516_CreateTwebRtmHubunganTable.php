<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebRtmHubunganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'TINYINT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_rtm_hubungan');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_rtm_hubungan');
    }
}
