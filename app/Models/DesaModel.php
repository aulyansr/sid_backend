<?php

namespace App\Models;

use CodeIgniter\Model;

class DesaModel extends Model
{
    protected $table      = 'desa';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nama_desa', 'permalink', 'theme_color'];

    // Validation rules
    protected $validationRules = [
        'nama_desa' => 'required|min_length[3]|max_length[255]',
        'permalink' => 'required|is_unique[desa.permalink]',
    ];

    protected $validationMessages = [
        'permalink' => [
            'is_unique' => 'The permalink must be unique.'
        ]
    ];

    protected $skipValidation = false;
}
