<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PendudukAttributesSeeder extends Seeder
{
    public function run()
    {
        $sex = [
            ['id' => 1, 'nama' => 'Laki - Laki'],
            ['id' => 2, 'nama' => 'Perempuan'],
        ];

        // Insert data into the sex table
        $this->db->table('tweb_penduduk_sex')->insertBatch($sex);

        // Data to be seeded
        $agama = [
            ['id' => 1, 'nama' => 'ISLAM'],
            ['id' => 2, 'nama' => 'KRISTEN'],
            ['id' => 3, 'nama' => 'KATHOLIK'],
            ['id' => 4, 'nama' => 'HINDU'],
            ['id' => 5, 'nama' => 'BUDHA'],
            ['id' => 6, 'nama' => 'KHONGHUCU'],
            ['id' => 7, 'nama' => 'KEPERCAYAAN TERHADAP TUHAN YME / LAINNYA'],
        ];

        // Insert data into the tweb_penduduk_agama table
        $this->db->table('tweb_penduduk_agama')->insertBatch($agama);

        $pendidikan = [
            ['id' => 1, 'nama' => 'TIDAK / BELUM SEKOLAH'],
            ['id' => 2, 'nama' => 'BELUM TAMAT SD/SEDERAJAT'],
            ['id' => 3, 'nama' => 'TAMAT SD / SEDERAJAT'],
            ['id' => 4, 'nama' => 'SLTP/SEDERAJAT'],
            ['id' => 5, 'nama' => 'SLTA / SEDERAJAT'],
            ['id' => 6, 'nama' => 'DIPLOMA I / II'],
            ['id' => 7, 'nama' => 'AKADEMI/ DIPLOMA III/S. MUDA'],
            ['id' => 8, 'nama' => 'DIPLOMA IV/ STRATA I'],
            ['id' => 9, 'nama' => 'STRATA II'],
            [
                'id' => 10,
                'nama' => 'STRATA III'
            ],
        ];

        // Insert data into the tweb_penduduk_pendidikan table
        $this->db->table('tweb_penduduk_pendidikan')->insertBatch($pendidikan);

        $hubungan = [
            ['id' => 1, 'nama' => 'KEPALA KELUARGA'],
            ['id' => 2, 'nama' => 'SUAMI'],
            ['id' => 3, 'nama' => 'ISTRI'],
            ['id' => 4, 'nama' => 'ANAK'],
            ['id' => 5, 'nama' => 'MENANTU'],
            ['id' => 6, 'nama' => 'CUCU'],
            ['id' => 7, 'nama' => 'ORANGTUA'],
            ['id' => 8, 'nama' => 'MERTUA'],
            ['id' => 9, 'nama' => 'FAMILI LAIN'],
            ['id' => 10, 'nama' => 'PEMBANTU'],
            ['id' => 11, 'nama' => 'LAINNYA'],
        ];

        // Insert data into the tweb_penduduk_hubungan table
        $this->db->table('tweb_penduduk_hubungan')->insertBatch($hubungan);

        $pekerjaan = [
            ['id' => 1, 'nama' => 'BELUM/TIDAK BEKERJA'],
            ['id' => 2, 'nama' => 'MENGURUS RUMAH TANGGA'],
            ['id' => 3, 'nama' => 'PELAJAR/MAHASISWA'],
            ['id' => 4, 'nama' => 'PENSIUNAN'],
            ['id' => 5, 'nama' => 'PEGAWAI NEGERI SIPIL (PNS)'],
            ['id' => 6, 'nama' => 'TENTARA NASIONAL INDONESIA (TNI)'],
            ['id' => 7, 'nama' => 'KEPOLISIAN RI (POLRI)'],
            ['id' => 8, 'nama' => 'PERDAGANGAN'],
            ['id' => 9, 'nama' => 'PETANI/PERKEBUNAN'],
            ['id' => 10, 'nama' => 'PETERNAK'],
            ['id' => 11, 'nama' => 'NELAYAN/PERIKANAN'],
            ['id' => 12, 'nama' => 'INDUSTRI'],
            ['id' => 13, 'nama' => 'KONSTRUKSI'],
            ['id' => 14, 'nama' => 'TRANSPORTASI'],
            ['id' => 15, 'nama' => 'KARYAWAN SWASTA'],
            ['id' => 16, 'nama' => 'KARYAWAN BUMN'],
            ['id' => 17, 'nama' => 'KARYAWAN BUMD'],
            ['id' => 18, 'nama' => 'KARYAWAN HONORER'],
            ['id' => 19, 'nama' => 'BURUH HARIAN LEPAS'],
            ['id' => 20, 'nama' => 'BURUH TANI/PERKEBUNAN'],
            ['id' => 21, 'nama' => 'BURUH NELAYAN/PERIKANAN'],
            ['id' => 22, 'nama' => 'BURUH PETERNAKAN'],
            ['id' => 23, 'nama' => 'PEMBANTU RUMAH TANGGA'],
            ['id' => 24, 'nama' => 'TUKANG CUKUR'],
            ['id' => 25, 'nama' => 'TUKANG LISTRIK'],
            ['id' => 26, 'nama' => 'TUKANG BATU'],
            ['id' => 27, 'nama' => 'TUKANG KAYU'],
            ['id' => 28, 'nama' => 'TUKANG SOL SEPATU'],
            ['id' => 29, 'nama' => 'TUKANG LAS/PANDAI BESI'],
            ['id' => 30, 'nama' => 'TUKANG JAHIT'],
            ['id' => 31, 'nama' => 'TUKANG GIGI'],
            ['id' => 32, 'nama' => 'PENATA RIAS'],
            ['id' => 33, 'nama' => 'PENATA BUSANA'],
            ['id' => 34, 'nama' => 'PENATA RAMBUT'],
            ['id' => 35, 'nama' => 'MEKANIK'],
            ['id' => 36, 'nama' => 'SENIMAN'],
            ['id' => 37, 'nama' => 'TABIB'],
            ['id' => 38, 'nama' => 'PARAJI'],
            ['id' => 39, 'nama' => 'PERANCANG BUSANA'],
            ['id' => 40, 'nama' => 'PENTERJEMAH'],
            ['id' => 41, 'nama' => 'IMAM MASJID'],
            ['id' => 42, 'nama' => 'PENDETA'],
            ['id' => 43, 'nama' => 'PASTOR'],
            ['id' => 44, 'nama' => 'WARTAWAN'],
            ['id' => 45, 'nama' => 'USTADZ/MUBALIGH'],
            ['id' => 46, 'nama' => 'JURU MASAK'],
            ['id' => 47, 'nama' => 'PROMOTOR ACARA'],
            ['id' => 48, 'nama' => 'ANGGOTA DPR-RI'],
            ['id' => 49, 'nama' => 'ANGGOTA DPD'],
            ['id' => 50, 'nama' => 'ANGGOTA BPK'],
            ['id' => 51, 'nama' => 'PRESIDEN'],
            ['id' => 52, 'nama' => 'WAKIL PRESIDEN'],
            ['id' => 53, 'nama' => 'ANGGOTA MAHKAMAH KONSTITUSI'],
            ['id' => 54, 'nama' => 'ANGGOTA KABINET KEMENTERIAN'],
            ['id' => 55, 'nama' => 'DUTA BESAR'],
            ['id' => 56, 'nama' => 'GUBERNUR'],
            ['id' => 57, 'nama' => 'WAKIL GUBERNUR'],
            ['id' => 58, 'nama' => 'BUPATI'],
            ['id' => 59, 'nama' => 'WAKIL BUPATI'],
            ['id' => 60, 'nama' => 'WALIKOTA'],
            ['id' => 61, 'nama' => 'WAKIL WALIKOTA'],
            ['id' => 62, 'nama' => 'ANGGOTA DPRD PROVINSI'],
            ['id' => 63, 'nama' => 'ANGGOTA DPRD KABUPATEN/KOTA'],
            ['id' => 64, 'nama' => 'DOSEN'],
            ['id' => 65, 'nama' => 'GURU'],
            ['id' => 66, 'nama' => 'PILOT'],
            ['id' => 67, 'nama' => 'PENGACARA'],
            ['id' => 68, 'nama' => 'NOTARIS'],
            ['id' => 69, 'nama' => 'ARSITEK'],
            ['id' => 70, 'nama' => 'AKUNTAN'],
            ['id' => 71, 'nama' => 'KONSULTAN'],
            ['id' => 72, 'nama' => 'DOKTER'],
            ['id' => 73, 'nama' => 'BIDAN'],
            ['id' => 74, 'nama' => 'PERAWAT'],
            ['id' => 75, 'nama' => 'APOTEKER'],
            ['id' => 76, 'nama' => 'PSIKIATER/PSIKOLOG'],
            ['id' => 77, 'nama' => 'PENYIAR TELEVISI'],
            ['id' => 78, 'nama' => 'PENYIAR RADIO'],
            ['id' => 79, 'nama' => 'PELAUT'],
            ['id' => 80, 'nama' => 'PENELITI'],
            ['id' => 81, 'nama' => 'SOPIR'],
            ['id' => 82, 'nama' => 'PIALANG'],
            ['id' => 83, 'nama' => 'PARANORMAL'],
            ['id' => 84, 'nama' => 'PEDAGANG'],
            ['id' => 85, 'nama' => 'PERANGKAT DESA'],
            ['id' => 86, 'nama' => 'KEPALA DESA'],
            ['id' => 87, 'nama' => 'BIARAWATI'],
            ['id' => 88, 'nama' => 'WIRASWASTA'],
            ['id' => 89, 'nama' => 'LAINNYA'],
        ];

        // Insert data into the tweb_penduduk_pekerjaan table
        $this->db->table('tweb_penduduk_pekerjaan')->insertBatch($pekerjaan);

        $warganegara = [
            ['id' => 1, 'nama' => 'WNI'],
            ['id' => 2, 'nama' => 'WNA'],
            ['id' => 3, 'nama' => 'DUA KEWARGANEGARAAN'],
        ];

        // Insert data into the tweb_warganegara table
        $this->db->table('tweb_penduduk_warganegara')->insertBatch($warganegara);

        $golonganDarah = [
            [
                'id' => 1,
                'nama' => 'A'
            ],
            [
                'id' => 2,
                'nama' => 'B'
            ],
            [
                'id' => 3,
                'nama' => 'AB'
            ],
            [
                'id' => 4,
                'nama' => 'O'
            ],
            [
                'id' => 5,
                'nama' => 'A+'
            ],
            [
                'id' => 6,
                'nama' => 'A-'
            ],
            [
                'id' => 7,
                'nama' => 'B+'
            ],
            [
                'id' => 8,
                'nama' => 'B-'
            ],
            [
                'id' => 9,
                'nama' => 'AB+'
            ],
            [
                'id' => 10,
                'nama' => 'AB-'
            ],
            [
                'id' => 11,
                'nama' => 'O+'
            ],
            [
                'id' => 12,
                'nama' => 'O-'
            ],
            [
                'id' => 13,
                'nama' => 'TIDAK TAHU'
            ],
        ];

        // Insert data into the tweb_golongan_darah table
        $this->db->table('tweb_golongan_darah')->insertBatch($golonganDarah);

        $status_penduduk = [
            ['id' => 1, 'nama' => 'Tetap'],
            ['id' => 2, 'nama' => 'Tidak Aktif'],
            ['id' => 3, 'nama' => 'Pendatang'],
        ];

        // Insert data into the status_penduduk table
        $this->db->table('tweb_penduduk_status')->insertBatch($status_penduduk);

        $cacat = [
            ['id' => 1, 'nama' => 'CACAT FISIK'],
            ['id' => 2, 'nama' => 'CACAT NETRA/BUTA'],
            ['id' => 3, 'nama' => 'CACAT RUNGU/WICARA'],
            ['id' => 4, 'nama' => 'CACAT MENTAL/JIWA'],
            ['id' => 5, 'nama' => 'CACAT FISIK DAN MENTAL'],
            ['id' => 6, 'nama' => 'CACAT LAINNYA'],
            ['id' => 7, 'nama' => 'TIDAK CACAT'],
        ];

        // Insert data into the tweb_cacat table
        $this->db->table('tweb_cacat')->insertBatch($cacat);

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
