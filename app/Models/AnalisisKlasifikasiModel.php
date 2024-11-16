<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisKlasifikasiModel extends Model
{
    protected $table = 'analisis_klasifikasi';  // Table name
    protected $primaryKey = 'id';  // Primary key

    protected $allowedFields = ['id_master', 'nama', 'minval', 'maxval'];  // Fields that can be updated

    protected $useTimestamps = false;  // Disable if you don't have `created_at`/`updated_at` fields
    protected $returnType = 'array';  // Return the result as an array

    // Validation rules (optional)
    protected $validationRules = [
        'id_master' => 'required|integer',
        'nama' => 'required|string|max_length[20]',
        'minval' => 'required|decimal',
        'maxval' => 'required|decimal',
    ];

    protected $validationMessages = [
        'id_master' => [
            'required' => 'ID Master is required',
            'integer' => 'ID Master must be an integer',
        ],
        'nama' => [
            'required' => 'Nama is required',
            'string' => 'Nama must be a string',
            'max_length' => 'Nama cannot exceed 20 characters',
        ],
        'minval' => [
            'required' => 'Minimum value is required',
            'decimal' => 'Minimum value must be a decimal number',
        ],
        'maxval' => [
            'required' => 'Maximum value is required',
            'decimal' => 'Maximum value must be a decimal number',
        ],
    ];
}
