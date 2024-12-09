<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaIdToGambarGallery extends Migration
{
    public function up()
    {
        $this->forge->addColumn('gambar_gallery', [
            'desa_id' => [
                'type' => 'INT',
                'null'       => true,
            ],
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('gambar_gallery', 'desa_id');
    }
}
