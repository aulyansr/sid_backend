<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori';
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
}
