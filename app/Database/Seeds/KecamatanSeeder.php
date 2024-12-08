<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $kecamatanData = [
            ['no_kecamatan' => 3, 'nama_kecamatan' => 'PLAYEN', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 4, 'nama_kecamatan' => 'PATUK', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 5, 'nama_kecamatan' => 'PALIYAN', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 6, 'nama_kecamatan' => 'PANGGANG', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 7, 'nama_kecamatan' => 'TEPUS', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 8, 'nama_kecamatan' => 'SEMANU', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 9, 'nama_kecamatan' => 'KARANGMOJO', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 10, 'nama_kecamatan' => 'PONJONG', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 11, 'nama_kecamatan' => 'RONGKOP', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 12, 'nama_kecamatan' => 'SEMIN', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 13, 'nama_kecamatan' => 'NGAWEN', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 14, 'nama_kecamatan' => 'GEDANGSARI', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 15, 'nama_kecamatan' => 'SAPTOSARI', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 16, 'nama_kecamatan' => 'GIRISUBO', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 17, 'nama_kecamatan' => 'TANJUNGSARI', 'no_kab' => 3, 'no_prop' => 34],
            ['no_kecamatan' => 18, 'nama_kecamatan' => 'PURWOSARI', 'no_kab' => 3, 'no_prop' => 34],
        ];



        // Insert data into the kecamatan table
        $this->db->table('kecamatan')->insertBatch($kecamatanData);
    }
}
