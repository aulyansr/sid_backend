<?php

namespace App\Models;

use CodeIgniter\Model;

class ClusterDesaModel extends Model
{
    protected $table = 'tweb_wil_clusterdesa';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'rt',
        'rw',
        'dusun',
        'id_kepala',
        'lat',
        'lng',
        'zoom',
        'path',
        'map_tipe',
        'parent'
    ];

    public function getClustersWithPamong()
    {
        return $this->select('tweb_wil_clusterdesa.*, tweb_desa_pamong.pamong_nama')
            ->join('tweb_desa_pamong', 'tweb_wil_clusterdesa.id_kepala = tweb_desa_pamong.pamong_id', 'left');
    }

    public function getDusun()
    {
        return $this->where('parent', null)->findAll(); // Adjust according to your database structure
    }

    public function getRW($dusunId)
    {
        return $this->where('parent', $dusunId)->findAll(); // Adjust according to your database structure
    }

    public function getRT($rwId)
    {
        return $this->where('parent', $rwId)->findAll(); // Adjust according to your database structure
    }
}
