<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToArtikel extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artikel', [
            'desa_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('artikel', 'desa_id');
    }
}
