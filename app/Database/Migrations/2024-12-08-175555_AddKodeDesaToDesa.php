<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKodeDesaToDesa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('desa', [
            'kode_desa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('desa', 'kode_desa');
    }
}
