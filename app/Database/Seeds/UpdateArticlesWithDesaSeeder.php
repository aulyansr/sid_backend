<?php

namespace App\Database\Seeds;

use App\Models\ArtikelModel;
use App\Models\DesaModel;
use CodeIgniter\Database\Seeder;

class UpdateArticlesWithDesaSeeder extends Seeder
{
    public function run()
    {
        // Load models
        $artikelModel = new ArtikelModel();
        $desaModel = new DesaModel();

        // Get the first village (desa)
        $desa = $desaModel->first();

        if ($desa) {
            // Update all articles with the first desa
            $this->db->table('artikel')
                ->set('desa_id', 1)
                ->update();
            echo "All articles have been updated to the first desa.\n";
        } else {
            echo "No desa found!\n";
        }
    }
}
