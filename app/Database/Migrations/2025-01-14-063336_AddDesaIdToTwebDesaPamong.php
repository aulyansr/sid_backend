<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToTwebDesaPamong extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tweb_desa_pamong', [
            'desa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tweb_desa_pamong', 'desa_id');
    }
}
