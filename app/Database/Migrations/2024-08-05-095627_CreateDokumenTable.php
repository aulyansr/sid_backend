<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'enabled' => [
                'type'       => 'INT',
                'constraint' => 1,
            ],
            'tgl_upload' => [
                'type'    => 'TIMESTAMP',
            ],
            'id_pend' => [
                'type'      => 'BIGINT',
                'unsigned'  => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('dokumen');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen');
    }
}
