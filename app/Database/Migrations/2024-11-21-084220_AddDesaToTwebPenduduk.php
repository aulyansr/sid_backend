<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDesaToTwebPenduduk extends Migration
{
    public function up()
    {
        $fields = [
            'desa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,    // Allow null if not all entries are linked to a desa
                'after'      => 'id',    // Place this column after 'id' or any other column
            ],
        ];

        // Add the new column
        $this->forge->addColumn('tweb_penduduk', $fields);

        // Optionally, add a foreign key constraint
        $this->db->query('
            ALTER TABLE tweb_penduduk
            ADD CONSTRAINT fk_desa_id
            FOREIGN KEY (desa_id)
            REFERENCES desa(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        // Drop the foreign key constraint first
        $this->db->query('ALTER TABLE tweb_penduduk DROP FOREIGN KEY fk_desa_id');

        // Drop the column
        $this->forge->dropColumn('tweb_penduduk', 'desa_id');
    }
}
