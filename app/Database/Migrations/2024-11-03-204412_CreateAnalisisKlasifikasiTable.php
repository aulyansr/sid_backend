<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnalisisKlasifikasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_master' => ['type' => 'INT', 'unsigned' => true],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 20],
            'minval'    => ['type' => 'DOUBLE PRECISION'],  // Removed constraint
            'maxval'    => ['type' => 'DOUBLE PRECISION'],  // Removed constraint
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('analisis_klasifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('analisis_klasifikasi');
    }
}
