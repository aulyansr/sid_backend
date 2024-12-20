<?php

namespace App\Controllers;

use App\Models\DesaModel;
use App\Models\KecamatanModel;

class Desa extends BaseController
{
    protected $desaModel;
    protected $db;

    public function __construct()
    {
        $this->desaModel = new DesaModel();
        $this->db = \Config\Database::connect();
    }


    public function index()
    {
        $data['villages'] = $this->desaModel->get_desa_with_config()->findAll();
        return view('desa/index', $data);
    }


    public function create()
    {
        return view('desa/create');
    }

    public function store()
    {
        // Retrieve the form data
        $data = $this->request->getPost();

        // Save the Desa record
        if ($this->desaModel->save($data)) {
            $desaId = $this->desaModel->insertID(); // Get the inserted ID
            $desa = $this->desaModel->find($desaId); // Find the newly created Desa

            // Create configuration data
            $config = $this->createConfig($desa['nama_desa'], $desa);

            // Default image path
            $defaultImagePath = 'path/to/default/image.jpg';

            // Create Profile Desa menu
            $profileMenuId = $this->createMenu('Profile Desa', '#', 1, 1, $desaId);

            // Define profile articles
            $profileArticles = [
                [
                    'judul'      => 'Sejarah Desa',
                    'isi'        => 'Sejarah dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desaId,
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'Potensi Desa',
                    'isi'        => 'Potensi dari ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desaId,
                    'id_user'    => 1,
                ],
            ];

            // Create articles and their respective menu items
            $this->createArticlesAndMenus($profileArticles, $desa, $desaId, $profileMenuId);

            $pemerintahanMenuId = $this->createMenu('Pemerintahan Desa', '#', 1, 1, $desaId);

            // Define profile articles
            $pemerintahanArticles = [
                [
                    'judul'       => 'Pemerintah Desa',
                    'isi'         => 'Pemerintah dari ' . $desa['nama_desa'],
                    'gambar'      => $defaultImagePath,
                    'enabled'     => 0,
                    'tgl_upload'  => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'    => 1,
                    'desa_id'     => $desa['id'],
                    'id_user'     => 1,
                ],
                [
                    'judul'       => 'Visi dan Misi Desa',
                    'isi'         => 'Visi dan Misi dari ' . $desa['nama_desa'],
                    'gambar'      => $defaultImagePath,
                    'enabled'     => 0,
                    'tgl_upload'  => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'    => 1,
                    'desa_id'     => $desa['id'],
                    'id_user'     => 1,
                ],
            ];

            // Create articles and their respective menu items
            $this->createArticlesAndMenus($pemerintahanArticles, $desa, $desaId, $pemerintahanMenuId);

            $lembagaMasyarakatId = $this->createMenu('Lembaga Masyarakat', '#', 1, 1, $desaId);

            // Define profile articles
            $lembagaMasyarakatArticles = [
                [
                    'judul'       => 'KARANG TARUNA',
                    'isi'         => 'Informasi mengenai Karang Taruna di ' . $desa['nama_desa'],
                    'gambar'      => $defaultImagePath,
                    'enabled'     => 0,
                    'tgl_upload'  => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'    => 1,
                    'desa_id'     => $desa['id'],
                    'id_user'     => 1,
                ],
                [
                    'judul'       => 'LPMD',
                    'isi'         => 'Informasi mengenai LPMD di ' . $desa['nama_desa'],
                    'gambar'      => $defaultImagePath,
                    'enabled'     => 0,
                    'tgl_upload'  => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'    => 1,
                    'desa_id'     => $desa['id'],
                    'id_user'     => 1,
                ],
                [
                    'judul'      => 'BPD',
                    'isi'        => 'Informasi mengenai BPD di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'PKK DESA',
                    'isi'        => 'Informasi mengenai PKK Desa di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'LPMP KERNEN',
                    'isi'        => 'Informasi mengenai LPMP Kernen di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
                [
                    'judul'      => 'RT',
                    'isi'        => 'Informasi mengenai RT di ' . $desa['nama_desa'],
                    'gambar'     => $defaultImagePath,
                    'enabled'    => 0,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline'   => 0,
                    'desa_id'    => $desa['id'],
                    'id_user'    => 1,
                ],
            ];


            // Create articles and their respective menu items
            $this->createArticlesAndMenus($lembagaMasyarakatArticles, $desa, $desaId, $lembagaMasyarakatId);

            // Redirect to the admin page with a success message
            return redirect()->to('admin/desa')->with('success', 'Record updated successfully.');
        }
    }

    private function createMenu($name, $link, $type, $linkType, $desaId)
    {
        // Insert menu data into the 'menu' table
        $this->db->table('menu')->insert([
            'nama'      => $name,
            'link'      => $link,
            'tipe'      => $type,
            'link_tipe' => $linkType,
            'enabled'   => 1,
            'desa_id'   => $desaId,
        ]);

        // Return the insert ID of the new menu
        return $this->db->insertID();
    }

    private function createArticlesAndMenus(array $articles, array $desa, int $desaId, int $parentMenuId)
    {
        // Initialize an array to hold article IDs
        $articleIds = [];

        // Loop through the articles and insert them into the 'artikel' table
        foreach ($articles as $article) {
            $this->db->table('artikel')->insert($article);
            $articleIds[$article['judul']] = $this->db->insertID(); // Store article IDs by title
        }

        // Insert corresponding menu items for each article
        foreach ($articles as $article) {
            $this->db->table('menu')->insert([
                'nama'      => $article['judul'],
                'link'      => base_url($desa['permalink'] . "/artikel/" . $articleIds[$article['judul']]),
                'link_tipe' => 0,
                'tipe'      => 0,
                'enabled'   => 1,
                'desa_id'   => $desaId,
                'parrent'   => $parentMenuId,
            ]);
        }
    }

    private function createConfig($name, $desa)
    {
        // Insert configuration data into the 'config' table
        $this->db->table('config')->insert([
            'nama_desa'         => $desa['nama_desa'],
            'kode_desa'         => $desa['permalink'],
            'nama_kepala_desa'  => 'Kepala ' . $desa['nama_desa'],
            'nip_kepala_desa'   => '12345' . $desa['id'],
            'desa_id'           => $desa['id'],
            'kode_pos'          => '12345',
            'email_desa'        => 'example@desa.com',
            'regid'             => 'REG123',
            'macid'             => 'MAC123',
            'nama_kecamatan'    => 'Default Kecamatan',
            'kode_kecamatan'    => 'K001',
            'nama_kepala_camat' => 'Default Camat',
            'nip_kepala_camat'  => '123456789',
            'nama_kabupaten'    => 'Default Kabupaten',
            'kode_kabupaten'    => 'KAB001',
            'nama_propinsi'     => 'Gunung Kidul',
            'kode_propinsi'     => 'PROV001',
            'logo'              => 'default_logo.png',
            'lat'               => '-6.1751',
            'lng'               => '106.8650',
            'zoom'              => 12,
            'map_tipe'          => 'roadmap',
            'path'              => '',
            'gapi_key'          => 'DEFAULT_API_KEY',
            'alamat_kantor'     => 'Jl. Default No.1',
            'g_analytic'        => 'UA-000000-1',
        ]);

        // Return the insert ID of the new config
        return $this->db->insertID();
    }


    public function edit($id)
    {
        $list_kecamatan         = new KecamatanModel();
        $data['list_kecamatan'] = $list_kecamatan->findAll();
        $data['desa']           = $this->desaModel->find($id);
        return view('desa/edit', $data);
    }


    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->desaModel->update($id, $data)) {
            return redirect()->to('admin/desa')->with('success', 'Record updated successfully.');
        } else {
            return redirect()->to('admin/desa')->with('error', $this->desaModel->errors());
        }
    }


    public function delete($id)
    {
        $this->desaModel->delete($id);
        return redirect()->to('/desa');
    }
}
