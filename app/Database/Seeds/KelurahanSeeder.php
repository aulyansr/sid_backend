<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    public function run()
    {
        $kelurahanData = [
            ['kode_desa' => '2013', 'nama_desa' => 'NGLERI', 'no_kecamatan' => '3', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'ngleri'],
            ['kode_desa' => '2003', 'nama_desa' => 'PENGKOK', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'pengkok'],
            ['kode_desa' => '2001', 'nama_desa' => 'BUNDER', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'bunder'],
            ['kode_desa' => '2005', 'nama_desa' => 'SALAM', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'salam'],
            ['kode_desa' => '2007', 'nama_desa' => 'NGORO-ORO', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'ngoro-oro'],
            ['kode_desa' => '2004', 'nama_desa' => 'SEMOYO', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'semoyo'],
            ['kode_desa' => '2002', 'nama_desa' => 'BEJI', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'beji'],
            ['kode_desa' => '2010', 'nama_desa' => 'NGLEGI', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'nglegi'],
            ['kode_desa' => '2009', 'nama_desa' => 'PUTAT', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'putat'],
            ['kode_desa' => '2006', 'nama_desa' => 'PATUK', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'patuk'],
            ['kode_desa' => '2008', 'nama_desa' => 'NGLANGGERAN', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'nglanggeran'],
            ['kode_desa' => '2011', 'nama_desa' => 'TERBAH', 'no_kecamatan' => '4', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'terbah'],
            ['kode_desa' => '2006', 'nama_desa' => 'MULUSAN', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'mulusan'],
            ['kode_desa' => '2002', 'nama_desa' => 'PAMPANG', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'pampang'],
            ['kode_desa' => '2005', 'nama_desa' => 'KARANGASEM', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'karangasem'],
            ['kode_desa' => '2007', 'nama_desa' => 'GIRING', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'giring'],
            ['kode_desa' => '2001', 'nama_desa' => 'SODO', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'sodo'],
            ['kode_desa' => '2003', 'nama_desa' => 'GROGOL', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'grogol'],
            ['kode_desa' => '2004', 'nama_desa' => 'KARANGDUWET', 'no_kecamatan' => '5', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'karangduwet'],
            ['kode_desa' => '2003', 'nama_desa' => 'GIRIMULYO', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'girimulyo'],
            ['kode_desa' => '2002', 'nama_desa' => 'GIRISEKAR', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'girisekar'],
            ['kode_desa' => '2005', 'nama_desa' => 'GIRIHARJO', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'giriharjo'],
            ['kode_desa' => '2004', 'nama_desa' => 'GIRIWUNGU', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'giriwungu'],
            ['kode_desa' => '2001', 'nama_desa' => 'GIRIKARTO', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'girikarto'],
            ['kode_desa' => '2006', 'nama_desa' => 'GIRISUKO', 'no_kecamatan' => '6', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'girisuko'],
            ['kode_desa' => '2004', 'nama_desa' => 'TEPUS', 'no_kecamatan' => '7', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'tepus'],
            ['kode_desa' => '2002', 'nama_desa' => 'SUMBERWUNGU', 'no_kecamatan' => '7', 'NO_KAB' => '3', 'NO_PROP' => '34', 'permalink' => 'sumberwungu'],

        ];



        // Insert data into the kelurahan table
        $this->db->table('kelurahan')->insertBatch($kelurahanData);
    }

    private function generateSlug($string)
    {
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $string));
    }
}
