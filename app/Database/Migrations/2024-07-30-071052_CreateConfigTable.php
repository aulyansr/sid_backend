<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_kepala_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nip_kepala_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => '6',
            ],
            'email_desa' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'regid' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'macid' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'nama_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_kepala_camat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nip_kepala_camat' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_propinsi' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'kode_propinsi' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'lat' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'lng' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'zoom' => [
                'type' => 'TINYINT',
            ],
            'map_tipe' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'path' => [
                'type' => 'TEXT',
            ],
            'gapi_key' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'alamat_kantor' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'g_analytic' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('config');
    }

    public function down()
    {
        $this->forge->dropTable('config');
    }
}
