<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KawinSeeder extends Seeder
{
    public function run()
    {
        $kawin = [
            ['id' => 1, 'nama' => 'BELUM KAWIN'],
            ['id' => 2, 'nama' => 'KAWIN'],
            ['id' => 3, 'nama' => 'CERAI HIDUP'],
            ['id' => 4, 'nama' => 'CERAI MATI'],
        ];

        // Insert data into the tweb_penduduk_kawin table
        $this->db->table('tweb_penduduk_kawin')->insertBatch($kawin);
    }
}
