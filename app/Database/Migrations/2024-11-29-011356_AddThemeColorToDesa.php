<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThemeColorToDesa extends Migration
{
    public function up()
    {
        // Add 'ThemeColor' column to the 'Desa' table
        $this->forge->addColumn('desa', [
            'theme_color' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        // Drop 'ThemeColor' column from the 'Desa' table
        $this->forge->dropColumn('desa', 'theme_color');
    }
}
