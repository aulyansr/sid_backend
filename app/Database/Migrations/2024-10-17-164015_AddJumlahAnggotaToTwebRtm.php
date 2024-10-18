<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJumlahAnggotaToTwebRtm extends Migration
{
    public function up()
    {
        // Add the jumlah_anggota column
        $this->forge->addColumn('tweb_rtm', [
            'jumlah_anggota' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, // Set to true if you want to allow NULL values
                'default' => 0, // Set a default value if necessary
            ],
        ]);
    }

    public function down()
    {
        // Drop the jumlah_anggota column
        $this->forge->dropColumn('tweb_rtm', 'jumlah_anggota');
    }
}
