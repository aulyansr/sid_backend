<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    // Protect Fields
    protected $allowedFields = [
        'nama',
        'link',
        'tipe',
        'parrent',
        'link_tipe',
        'enabled'
    ];

    // Auto timestamp
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|max_length[50]',
        'link' => 'required|max_length[500]',
        'tipe' => 'required|integer',
        'parrent' => 'permit_empty|integer',
        'link_tipe' => 'required|integer|in_list[0,1]',
        'enabled' => 'required|integer',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}
