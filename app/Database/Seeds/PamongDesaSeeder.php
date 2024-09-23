<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PamongDesaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['pamong_nama' => 'ISWANTOHADI S.Sos', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'LURAH', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'TRI JUNIANTO, SE', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'CARIK', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'Sapto Nugroho M, S.Pd.I', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'Jagabaya', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'RIKA AJI HARTANTO', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'ULU\'ULU', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'IGMA AYIRIDHONA', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'KEPALA URUSAN PANGRIPTA', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'AMINTO SUDARSO', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'DUKUH KERNEN', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'PUJO SUROTO', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'DUKUH NGUNUT TENGAH', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'HANUNG PAMBUDI', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'DUKUH NGUNUT LOR', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'SURATJIMAN', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'Staf', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'SUKINO', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'Staf', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'NOVIANA NUR FATIMAH', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'DANARTA', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'RENIKA CANDRASARI', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'TATALAKSANA', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
            ['pamong_nama' => 'ERI SETYANINGRUM', 'pamong_nip' => $this->generateRandomNumber(), 'pamong_nik' => $this->generateRandomNumber(), 'jabatan' => 'KAMITUWO', 'pamong_status' => '1', 'pamong_tgl_terdaftar' => date('Y-m-d')],
        ];

        // Insert data into the database
        foreach ($data as $row) {
            $this->db->table('tweb_desa_pamong')->insert($row);
        }
    }

    private function generateRandomNumber()
    {
        return str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    }
}
