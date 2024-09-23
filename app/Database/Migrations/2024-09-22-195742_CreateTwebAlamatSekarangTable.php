<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebAlamatSekarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'jalan'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'rt'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'rw'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'dusun'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'desa'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'kecamatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'kabupaten' => ['type' => 'VARCHAR', 'constraint' => 100],
            'provinsi'  => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tweb_alamat_sekarang');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_alamat_sekarang');
    }
}
