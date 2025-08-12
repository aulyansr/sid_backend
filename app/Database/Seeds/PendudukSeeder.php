<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DesaModel;
use Faker\Factory;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $desaModel = new DesaModel();

        // Fetch all villages (desa)
        $allVillages = $desaModel->findAll();
        if (empty($allVillages)) {
            return;
        }

        // Number of residents to generate per desa
        $numResidentsPerDesa = 100;

        foreach ($allVillages as $village) {
            $batchRowsForVillage = [];

            for ($i = 0; $i < $numResidentsPerDesa; $i++) {
                $batchRowsForVillage[] = [
                    'nama' => $faker->name,
                    'nik' => $faker->numerify('###############'),
                    'id_kk' => $faker->numberBetween(1, 50),
                    'kk_level' => $faker->numberBetween(1, 5),
                    'id_rtm' => null,
                    'rtm_level' => null,
                    'sex' => $faker->randomElement([1, 2]),
                    'tempatlahir' => $faker->city,
                    'tanggallahir' => $faker->date('Y-m-d', '20-12-31'),
                    'agama_id' => $faker->numberBetween(1, 7),
                    'pendidikan_kk_id' => $faker->numberBetween(1, 10),
                    'pendidikan_id' => $faker->numberBetween(1, 10),
                    'pendidikan_sedang_id' => $faker->numberBetween(1, 10),
                    'pekerjaan_id' => $faker->numberBetween(1, 89),
                    'status_kawin' => $faker->numberBetween(1, 4),
                    'warganegara_id' => $faker->numberBetween(1, 2),
                    'dokumen_pasport' => $faker->optional()->numerify('########'),
                    'dokumen_kitas' => $faker->optional()->numerify('########'),
                    'ayah_nik' => $faker->numerify('###############'),
                    'ibu_nik' => $faker->numerify('###############'),
                    'nama_ayah' => $faker->name('male'),
                    'nama_ibu' => $faker->name('female'),
                    'foto' => null,
                    'golongan_darah_id' => $faker->numberBetween(1, 4),
                    'id_cluster' => 3,
                    'status' => $faker->numberBetween(1, 3),
                    'alamat_sebelumnya' => $faker->address,
                    'alamat_sekarang' => $faker->address,
                    'status_dasar' => $faker->numberBetween(1, 3),
                    'hamil' => $faker->randomElement([1, 2]),
                    'cacat_id' => $faker->numberBetween(1, 5),
                    'sakit_menahun_id' => $faker->numberBetween(1, 5),
                    'jamkesmas' => $faker->randomElement([1, 2]),
                    'akta_lahir' => $faker->numerify('########'),
                    'akta_perkawinan' => $faker->optional()->numerify('########'),
                    'tanggalperkawinan' => $faker->optional()->date('Y-m-d'),
                    'akta_perceraian' => $faker->optional()->numerify('########'),
                    'tanggalperceraian' => $faker->optional()->date('Y-m-d'),
                    'desa_id' => $village['id'],
                ];
            }

            // Insert per desa batch to limit memory
            if (!empty($batchRowsForVillage)) {
                $this->db->table('tweb_penduduk')->insertBatch($batchRowsForVillage);
            }
        }
    }
}
