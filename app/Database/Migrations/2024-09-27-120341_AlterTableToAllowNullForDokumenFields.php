<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableToAllowNullForDokumenFields extends Migration
{
    public function up()
    {

        $this->forge->modifyColumn('tweb_penduduk', [
            'dokumen_pasport' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true, // Set to allow NULL
            ],
            'dokumen_kitas' => [
                'type'       => 'INT',
                'null'       => true, // Set to allow NULL
            ],
        ]);
    }

    public function down()
    {

        $this->forge->modifyColumn('tweb_penduduk', [
            'dokumen_pasport' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => false, // Set back to NOT NULL if required
            ],
            'dokumen_kitas' => [
                'type'       => 'INT',
                'null'       => false, // Set back to NOT NULL if required
            ],
        ]);
    }
}
