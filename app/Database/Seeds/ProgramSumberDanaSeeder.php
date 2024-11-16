<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramSumberDanaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['sumber_dana' => 'APBKal'],
            ['sumber_dana' => 'APBD KAB'],
            ['sumber_dana' => 'APBD PROV'],
            ['sumber_dana' => 'APBN'],
            ['sumber_dana' => 'Swasta'],
            ['sumber_dana' => 'CSR'],
        ];

        // Insert data into the program_sumber_dana table
        $this->db->table('program_sumber_dana')->insertBatch($data);
    }
}
