<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoKabNoPropToDesa extends Migration
{
    public function up()
    {
        $fields = [
            'no_kab' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'no_prop' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'after' => 'NO_KAB',
            ],
        ];

        $this->forge->addColumn('desa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('desa', 'no_kab');
        $this->forge->dropColumn('desa', 'no_prop');
    }
}
