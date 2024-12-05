<?php

namespace App\Models;

use CodeIgniter\Model;

class KelurahanModel extends Model
{
    protected $table         = 'kelurahan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_kel', 'nama_kelurahan', 'no_kec', 'no_kab', 'no_prop'];

    public function getKecamatan()
    {
        return $this->select('kelurahan.*, desa.nama_desa')
            ->join('desa', 'kelurahan.no_kec = desa.id', 'left');
    }
}
