<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $data = [

            ['id' => 3, 'nama_desa' => 'PLAYEN', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'playen'],
            ['id' => 4, 'nama_desa' => 'PATUK', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'patuk'],
            ['id' => 5, 'nama_desa' => 'PALIYAN', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'paliyan'],
            ['id' => 6, 'nama_desa' => 'PANGGANG', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'panggang'],
            ['id' => 7, 'nama_desa' => 'TEPUS', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'tepus'],
            ['id' => 8, 'nama_desa' => 'SEMANU', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'semanu'],
            ['id' => 9, 'nama_desa' => 'KARANGMOJO', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'karangmojo'],
            ['id' => 10, 'nama_desa' => 'PONJONG', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'ponjong'],
            ['id' => 11, 'nama_desa' => 'RONGKOP', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'rongkop'],
            ['id' => 12, 'nama_desa' => 'SEMIN', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'semin'],
            ['id' => 13, 'nama_desa' => 'NGAWEN', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'ngawen'],
            ['id' => 14, 'nama_desa' => 'GEDANGSARI', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'gedangsari'],
            ['id' => 15, 'nama_desa' => 'SAPTOSARI', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'saptosari'],
            ['id' => 16, 'nama_desa' => 'GIRISUBO', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'girisubo'],
            ['id' => 17, 'nama_desa' => 'TANJUNGSARI', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'tanjungsari'],
            ['id' => 18, 'nama_desa' => 'PURWOSARI', 'no_kab' => 3, 'no_prop' => 34, 'permalink' => 'purwosari'],
        ];


        // Insert batch data
        $this->db->table('desa')->insertBatch($data);
    }
}
