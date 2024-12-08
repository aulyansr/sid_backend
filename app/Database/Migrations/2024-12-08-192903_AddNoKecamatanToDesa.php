<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoKecamatanToDesa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('desa', [
            'no_kecamatan' => [
                'type'       => 'INT',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('desa', 'no_kecamatan');
    }
}
