<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToMenu extends Migration
{
    public function up()
    {
        $this->forge->addColumn('menu', [
            'desa_id' => [
                'type' => 'INT',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('menu', 'desa_id');
    }
}
