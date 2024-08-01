<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        // Data to be seeded
        $data = [
            [
                'kategori' => 'Berita Desa',
                'tipe' => 0,
                'urut' => 1,
                'enabled' => 1,
                'parrent' => 0
            ],
            [
                'kategori' => 'Produk Desa',
                'tipe' => 0,
                'urut' => 2,
                'enabled' => 1,
                'parrent' => 0
            ],
            [
                'kategori' => 'Agenda Desa',
                'tipe' => 0,
                'urut' => 3,
                'enabled' => 1,
                'parrent' => 0
            ],
            [
                'kategori' => 'Peraturan Desa',
                'tipe' => 0,
                'urut' => 4,
                'enabled' => 1,
                'parrent' => 0
            ],
            [
                'kategori' => 'Laporan Desa',
                'tipe' => 0,
                'urut' => 5,
                'enabled' => 1,
                'parrent' => 0
            ]
        ];

        // Insert data into the 'kategori' table
        $this->db->table('kategori')->insertBatch($data);
    }
}
