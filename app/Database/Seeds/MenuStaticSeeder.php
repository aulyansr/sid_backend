<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DesaModel;

class MenuStaticSeeder extends Seeder
{
    public function run()
    {
        $desaModel = new DesaModel();
        $desaList = $desaModel->where('id !=', 1)->findAll();

        // Path gambar default untuk artikel
        $defaultImagePath = 'public/uploads/default_image.png';

        foreach ($desaList as $desa) {
            // Tambahkan menu "Profile Desa"
            $this->db->table('menu')->insert([
                'nama'      => 'Profile Desa',
                'link'      => '#',
                'tipe'      => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
                'desa_id'   => $desa['id'],
            ]);

            $profileDesaId = $this->db->insertID(); // ID menu "Profile Desa"

            // Artikel terkait "Profile Desa"
            $articles = [
                [
                    'judul'      => 'Sejarah Desa',
                    'isi'        => 'Sejarah dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'Potensi Desa',
                    'isi'        => 'Potensi dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'Peta Balai Desa',
                    'isi'        => 'Peta Balai Desa ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
            ];

            // Simpan artikel dan dapatkan ID-nya
            $articleIds = [];
            foreach ($articles as $article) {
                $this->db->table('artikel')->insert($article);
                $articleIds[$article['judul']] = $this->db->insertID();
            }

            // Tambahkan menu untuk masing-masing artikel
            $menus = [
                [
                    'nama'      => 'Sejarah Desa',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['Sejarah Desa']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $profileDesaId, // Hubungkan dengan menu "Profile Desa"
                ],
                [
                    'nama'      => 'Potensi Desa',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['Potensi Desa']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $profileDesaId,
                ],
                [
                    'nama'      => 'Peta Balai Desa',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['Peta Balai Desa']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $profileDesaId,
                ],
            ];

            // Insert the menu items for the profile desa
            foreach ($menus as $menu) {
                $this->db->table('menu')->insert($menu);
            }

            // Menu for "Pemerintahan Desa"
            $this->db->table('menu')->insert([
                'nama'      => 'Pemerintahan Desa',
                'link'      => '#',
                'tipe'      => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
                'desa_id'   => $desa['id'],
            ]);

            $pemerintahDesaId = $this->db->insertID(); // ID menu "Pemerintahan Desa"

            // Artikel terkait "Pemerintahan Desa"
            $pemerintahanArticles = [
                [
                    'judul'      => 'Pemerintah Desa',
                    'isi'        => 'Pemerintah dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'Visi dan Misi Desa',
                    'isi'        => 'Visi dan Misi dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
            ];

            // Simpan artikel pemerintahan dan dapatkan ID-nya
            $pemerintahanArticleIds = [];
            foreach ($pemerintahanArticles as $article) {
                $this->db->table('artikel')->insert($article);
                $pemerintahanArticleIds[$article['judul']] = $this->db->insertID();
            }

            // Tambahkan menu untuk masing-masing artikel pemerintah desa
            $pemerintahanMenus = [
                [
                    'nama'      => 'Pemerintah',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $pemerintahanArticleIds['Pemerintah Desa']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $pemerintahDesaId, // Hubungkan dengan menu "Pemerintahan Desa"
                ],
                [
                    'nama'      => 'Visi dan Misi',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $pemerintahanArticleIds['Visi dan Misi Desa']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $pemerintahDesaId,
                ],
            ];

            // Insert the menu items for pemerintahan desa
            foreach ($pemerintahanMenus as $menu) {
                $this->db->table('menu')->insert($menu);
            }
            // Lembaga Masyarakat
            $this->db->table('menu')->insert([
                'nama'      => 'Lembaga Masyarakat',
                'link'      => '#',
                'tipe'      => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
                'desa_id'   => $desa['id'],
            ]);

            $lembagaMasyarakatId = $this->db->insertID(); // ID menu "Lembaga Masyarakat"

            // Artikel terkait "Lembaga Masyarakat"
            $articles = [
                [
                    'judul'      => 'KARANG TARUNA',
                    'isi'        => 'Informasi mengenai Karang Taruna di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'LPMD',
                    'isi'        => 'Informasi mengenai LPMD di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'BPD',
                    'isi'        => 'Informasi mengenai BPD di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'PKK DESA',
                    'isi'        => 'Informasi mengenai PKK Desa di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'LPMP KERNEN',
                    'isi'        => 'Informasi mengenai LPMP Kernen di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'RT',
                    'isi'        => 'Informasi mengenai RT di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 1,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
            ];

            // Simpan artikel dan dapatkan ID-nya
            $articleIds = [];
            foreach ($articles as $article) {
                $this->db->table('artikel')->insert($article);
                $articleIds[$article['judul']] = $this->db->insertID();
            }

            // Tambahkan menu untuk masing-masing artikel
            $menus = [
                [
                    'nama'      => 'KARANG TARUNA',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['KARANG TARUNA']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId, // Hubungkan dengan menu "Lembaga Masyarakat"
                ],
                [
                    'nama'      => 'LPMD',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['LPMD']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId,
                ],
                [
                    'nama'      => 'BPD',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['BPD']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId,
                ],
                [
                    'nama'      => 'PKK DESA',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['PKK DESA']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId,
                ],
                [
                    'nama'      => 'LPMP KERNEN',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['LPMP KERNEN']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId,
                ],
                [
                    'nama'      => 'RT',
                    'link'      => base_url($desa['permalink'] . '/artikel/' . $articleIds['RT']),
                    'link_tipe' => 0,
                    'tipe'      => 0,
                    'enabled'   => 1,
                    'desa_id'   => $desa['id'],
                    'parrent'   => $lembagaMasyarakatId,
                ],
            ];

            // Insert the menu items into the 'menu' table
            foreach ($menus as $menu) {
                $this->db->table('menu')->insert($menu);
            }
        }
    }
}
