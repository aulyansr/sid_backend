<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebPendudukMandiriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nik'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'pin'          => ['type' => 'VARCHAR', 'constraint' => 60],
            'tanggal_buat' => ['type' => 'TIMESTAMP'],
            'last_login'   => ['type' => 'DATETIME'],
        ]);
        $this->forge->createTable('tweb_penduduk_mandiri');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_penduduk_mandiri');
    }
}
