<?php

namespace App\Models;

use CodeIgniter\Model;
use \Tatter\Relations\Traits\ModelTrait;

class ArtikelModel extends Model
{
    protected $table      = 'artikel';
    protected $with = 'user';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'gambar',
        'isi',
        'enabled',
        'tgl_upload',
        'id_kategori',
        'id_user',
        'judul',
        'headline',
        'gambar1',
        'gambar2',
        'gambar3',
        'dokumen',
        'link_dokumen'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'gambar'       => 'required|string|max_length[200]',
        'isi'          => 'required|string',
        'enabled'      => 'required|integer|max_length[1]',
        'tgl_upload'   => 'permit_empty|valid_date',
        'id_kategori'  => 'permit_empty|integer',
        'id_user'      => 'required|integer',
        'judul'        => 'required|string|max_length[100]',
        'headline'     => 'integer|max_length[1]',
        'gambar1'      => 'permit_empty|string|max_length[200]',
        'gambar2'      => 'permit_empty|string|max_length[200]',
        'gambar3'      => 'permit_empty|string|max_length[200]',
        'dokumen'      => 'permit_empty|string|max_length[400]',
        'link_dokumen' => 'permit_empty|string|max_length[200]',
    ];

    protected $validationMessages = [];

    // Define relationships
    public function getKategori($id_kategori)
    {
        $kategoriModel = new \App\Models\KategoriModel();
        return $kategoriModel->find($id_kategori);
    }

    public function getUser($id_user)
    {
        $userModel = new \App\Models\UserModel();
        return $userModel->find($id_user);
    }

    // Fetch all articles with related kategori and user
    public function getArtikels()
    {
        $builder = $this->builder();
        $builder->select('artikel.*, kategori.kategori as kategori_name, users.username as user_name, users.foto as user_foto');
        $builder->join('kategori', 'kategori.id = artikel.id_kategori', 'left');
        $builder->join('users', 'users.id = artikel.id_user', 'left');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
