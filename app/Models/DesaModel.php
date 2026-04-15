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

    protected $allowedFields = ['nama_desa', 'permalink', 'theme_color', 'kode_desa','no_kecamatan'];

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

    public function getDesaWithCounts()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table)
            ->select('desa.id, desa.nama_desa, desa.permalink, 
                      COUNT(DISTINCT artikel.id) as total_artikel, 
                      COUNT(DISTINCT gallery.id) as total_gallery')
            ->join('artikel', 'artikel.desa_id = desa.id', 'left')
            ->join('gallery', 'gallery.desa_id = desa.id', 'left')
            ->groupBy('desa.id')
            ->get()
            ->getResultArray();
    }
}
