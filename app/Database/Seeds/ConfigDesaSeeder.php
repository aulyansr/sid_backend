<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DesaModel;

class ConfigDesaSeeder extends Seeder
{
    public function run()
    {
        $desaModel = new DesaModel();


        $desaList = $desaModel->findAll();


        $baseConfig = [
            'kode_pos' => '12345',
            'email_desa' => 'example@desa.com',
            'regid' => 'REG123',
            'macid' => 'MAC123',
            'nama_kecamatan' => 'Default Kecamatan',
            'kode_kecamatan' => 'K001',
            'nama_kepala_camat' => 'Default Camat',
            'nip_kepala_camat' => '123456789',
            'nama_kabupaten' => 'Default Kabupaten',
            'kode_kabupaten' => 'KAB001',
            'nama_propinsi' => 'Gunung Kidul',
            'kode_propinsi' => 'PROV001',
            'logo' => 'default_logo.png',
            'lat' => '-6.1751',
            'lng' => '106.8650',
            'zoom' => 12,
            'map_tipe' => 'roadmap',
            'path' => '',
            'gapi_key' => 'DEFAULT_API_KEY',
            'alamat_kantor' => 'Jl. Default No.1',
            'g_analytic' => 'UA-000000-1',
        ];

        $data = [];


        foreach ($desaList as $desa) {
            $data[] = array_merge($baseConfig, [
                'nama_desa' => $desa['nama_desa'],
                'kode_desa' => $desa['permalink'],
                'nama_kepala_desa' => 'Kepala ' . $desa['nama_desa'],
                'nip_kepala_desa' => '12345' . $desa['id'],
                'desa_id' => $desa['id'],
            ]);
        }


        $this->db->table('config')->insertBatch($data);
    }
}
