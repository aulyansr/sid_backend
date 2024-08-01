<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGambarGalleryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'parrent' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'enabled' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'tgl_upload' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
            ],
            'tipe' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('gambar_gallery');
    }

    public function down()
    {
        $this->forge->dropTable('gambar_gallery');
    }
}
