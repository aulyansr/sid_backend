<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllowKelasSosialNullInTwebRtm extends Migration
{
    public function up()
    {
        // Modify kelas_sosial to allow NULL values
        $this->forge->modifyColumn('tweb_rtm', [
            'kelas_sosial' => [
                'type' => 'VARCHAR',
                'null' => true,  // Set to true to allow NULL
                'constraint' => 255, // Change the constraint if needed
            ],
        ]);
    }

    public function down()
    {
        // Revert the change: disallow NULL values (if needed)
        $this->forge->modifyColumn('tweb_rtm', [
            'kelas_sosial' => [
                'type' => 'VARCHAR',
                'null' => false,  // Change back to false if needed
                'constraint' => 255,
            ],
        ]);
    }
}
