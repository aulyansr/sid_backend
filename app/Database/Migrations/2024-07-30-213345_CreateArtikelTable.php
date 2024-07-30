<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArtikelTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'gambar'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
            ],
            'isi'          => [
                'type'           => 'TEXT',
            ],
            'enabled'      => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => 1,
            ],
            'tgl_upload'   => [
                'type'           => 'TIMESTAMP',
            ],
            'id_kategori'  => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'id_user'      => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'judul'        => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'headline'     => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => 0,
            ],
            'gambar1'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
                'null'           => true,
            ],
            'gambar2'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
                'null'           => true,
            ],
            'gambar3'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
                'null'           => true,
            ],
            'dokumen'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '400',
                'null'           => true,
            ],
            'link_dokumen' => [
                'type'           => 'VARCHAR',
                'constraint'     => '200',
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('artikel');
    }

    public function down()
    {
        $this->forge->dropTable('artikel');
    }
}
