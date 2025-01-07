<?php

namespace App\Models;

use CodeIgniter\Model;

class KeluargaModel extends Model
{
    protected $table      = 'tweb_keluarga';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'no_kk',
        'nik_kepala',
        'tgl_daftar',
        'kelas_sosial',
        'raskin',
        'id_bedah_rumah',
        'id_pkh',
        'id_blt',
        'desa_id'
    ];

    public function getKepalaKeluarga()
    {
        return $this->select('tweb_keluarga.*, 
                          tweb_penduduk.nik AS nik_kepala, 
                          tweb_penduduk.nama AS nama_kepala, 
                          (SELECT COUNT(*) 
                           FROM tweb_penduduk 
                           WHERE tweb_penduduk.id_kk = tweb_keluarga.id) AS jumlah_anggota')
            ->join('tweb_penduduk', 'tweb_penduduk.nik = tweb_keluarga.nik_kepala', 'left')
            ->findAll();
    }
}
