<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebDesaPamongTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pamong_id'           => ['type' => 'INT', 'auto_increment' => true],
            'pamong_nama'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'pamong_nip'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'pamong_nik'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'jabatan'             => ['type' => 'VARCHAR', 'constraint' => 50],
            'pamong_status'       => ['type' => 'VARCHAR', 'constraint' => 45],
            'pamong_tgl_terdaftar' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('pamong_id', true);
        $this->forge->createTable('tweb_desa_pamong');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_desa_pamong');
    }
}
