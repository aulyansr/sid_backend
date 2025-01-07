<?php

namespace App\Models;

use CodeIgniter\Model;

class RtmModel extends Model
{
    protected $table      = 'tweb_rtm';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nik_kepala',
        'no_kk',
        'tgl_daftar',
        'kelas_sosial',
        'jumlah_anggota',
        'desa_id'
    ];

    public function getKepalaRtm()
    {
        return $this->select('tweb_rtm.*, 
                          tweb_penduduk.nik AS nik_kepala, 
                          tweb_penduduk.nama AS nama_kepala')
            ->join('tweb_penduduk', 'tweb_penduduk.nik = tweb_rtm.nik_kepala', 'left')
            ->findAll();
    }
}
