<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAnalisisMasterTable extends Migration
{
    public function up()
    {
        // Modify the id_child and id_kelompok columns to allow NULL
        $this->forge->modifyColumn('analisis_master', [
            'id_child' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_kelompok' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        // If you need to revert this change, you can set these fields back to NOT NULL
        $this->forge->modifyColumn('analisis_master', [
            'id_child' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
            ],
            'id_kelompok' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0,
            ],
        ]);
    }
}
