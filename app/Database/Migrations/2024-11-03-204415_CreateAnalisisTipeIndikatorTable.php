<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisTipeIndikatorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipe' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id'   => ['type' => 'TINYINT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_tipe_indikator');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_tipe_indikator');
    }
}
