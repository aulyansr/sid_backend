<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentToTwebWilClusterdesa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tweb_wil_clusterdesa', [
            'parent' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
                'after' => 'dusun', // Specify after which column to add it (optional)
            ],
        ]);
    }

    public function down()
    {
        // This method will be used to reverse the migration by dropping the 'parent' column
        $this->forge->dropColumn('tweb_wil_clusterdesa', 'parent');
    }
}
