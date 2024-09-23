<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SexSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'    => 1,
            ],
            [
                'nama'    => 2,
            ],
        ];

        // Using Query Builder
        $this->db->table('tweb_penduduk_sex')->insertBatch($data);
    }
}
