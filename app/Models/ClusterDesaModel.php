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
        return $this->where('parent', null)->findAll(); // Get all dusun without a parent
    }

    public function getRW($dusunId)
    {
        return $this->where('parent', $dusunId)->findAll(); // Get all RW under a given dusun
    }

    public function getRT($rwId)
    {
        return $this->where('parent', $rwId)->findAll(); // Get all RT under a given RW
    }

    public function parentRW($rtId)
    {
        $rt = $this->find($rtId);
        $rw = $this->find($rt['parent']);
        return $rw; // Return the parent RW of a given RT
    }

    public function parentDusun($rwId)
    {
        $rw = $this->find($rwId);
        $dusun = $this->find($rw['parent']);
        return $dusun; // Return the parent Dusun of a given RW
    }
}
