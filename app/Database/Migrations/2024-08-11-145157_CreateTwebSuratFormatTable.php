<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwebSuratFormatTable extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'url_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'kunci' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'favorit' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tweb_surat_format');
    }

    public function down()
    {
        $this->forge->dropTable('tweb_surat_format');
    }
}
