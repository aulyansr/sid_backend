<?php

namespace App\Models;

use CodeIgniter\Model;
use \Tatter\Relations\Traits\ModelTrait;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
    protected $with = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'kategori', 'tipe', 'urut', 'enabled', 'parrent'
    ];

    protected $validationRules = [
        'kategori' => 'required|max_length[100]',
        'tipe' => 'required|integer',
        'urut' => 'required|integer|max_length[3]',
        'enabled' => 'required|integer|max_length[1]',
        'parrent' => 'integer|max_length[3]'
    ];

    public function getCategoriesWithArticles()
    {
        $builder = $this->db->table('kategori');
        $builder->join('artikel', 'kategori.id = artikel.id_kategori', 'left');
        $builder->select('kategori.*, artikel.judul, artikel.tgl_upload');
        $builder->where('kategori.enabled', 1);
        $builder->orderBy('urut');
        return $builder->get()->getResult();
    }
}
