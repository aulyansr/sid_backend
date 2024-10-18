<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_master', 'id_ketua', 'kode', 'nama', 'keterangan'];
    protected $useTimestamps = false;

    public function get_all_attributes()
    {
        return $this->select('kelompok.*, 
                          tweb_penduduk.nama AS ketua, 
                          kelompok_master.kelompok AS jenis_kelompok') // Adjusted to select 'nama' from kelompok_master
            ->join('tweb_penduduk', 'tweb_penduduk.nik = kelompok.id_ketua', 'left')
            ->join('kelompok_master', 'kelompok_master.id = kelompok.id_master', 'left') // Added join for kelompok_master
            ->findAll();
    }
}
