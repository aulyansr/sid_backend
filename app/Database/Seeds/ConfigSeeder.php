<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_desa' => 'Desa A',
                'kode_desa' => 'D001',
                'nama_kepala_desa' => 'Kepala Desa A',
                'nip_kepala_desa' => '1234567890',
                'kode_pos' => '12345',
                'email_desa' => 'desaA@example.com',
                'regid' => 'REG001',
                'macid' => 'MAC001',
                'nama_kecamatan' => 'Kecamatan A',
                'kode_kecamatan' => 'K001',
                'nama_kepala_camat' => 'Kepala Camat A',
                'nip_kepala_camat' => '0987654321',
                'nama_kabupaten' => 'Kabupaten A',
                'kode_kabupaten' => 'KB001',
                'nama_propinsi' => 'Propinsi A',
                'kode_propinsi' => 'PR001',
                'logo' => 'logo_a.png',
                'lat' => '-6.200000',
                'lng' => '106.816666',
                'zoom' => 10,
                'map_tipe' => 'satellite',
                'path' => '/path/to/resource',
                'gapi_key' => 'APIKEY001',
                'alamat_kantor' => 'Jl. Contoh No.1',
                'g_analytic' => 'GA12345678',
            ],

        ];

        // Insert data
        $this->db->table('config')->insertBatch($data);
    }
}
