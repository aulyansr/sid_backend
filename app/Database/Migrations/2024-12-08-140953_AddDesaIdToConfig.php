<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToConfig extends Migration
{
    public function up()
    {
        $this->forge->addColumn('config', [
            'desa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('config', 'desa_id');
    }
}
