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

    protected $allowedFields = ['nama_desa', 'permalink', 'theme_color', 'kode_desa'];

    // Validation rules
    protected $validationRules = [
        'nama_desa' => 'required',
        'permalink' => 'required|is_unique[desa.permalink]',
    ];

    protected $validationMessages = [
        'permalink' => [
            'is_unique' => 'The permalink must be unique.'
        ]
    ];

    public function get_desa_with_config()
    {
        return $this->select("desa.*, config.id As config_id, kecamatan.nama_kecamatan as nama_kecamatan")
            ->join("config", "config.desa_id = desa.id", "left")
            ->join("kecamatan", "kecamatan.no_kecamatan = desa.no_kecamatan", "left");
    }
}
