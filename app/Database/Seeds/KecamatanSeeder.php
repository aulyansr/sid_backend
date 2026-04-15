<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $kecamatanData = [
                       ['no_kecamatan' => 1, 'nama_kecamatan' => 'NGLIPAR', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 2, 'nama_kecamatan' => 'WONOSARI', 'no_kab' => 3, 'no_prop' => 34],        ];



        // Insert data into the kecamatan table
        $this->db->table('kecamatan')->insertBatch($kecamatanData);
    }
}
