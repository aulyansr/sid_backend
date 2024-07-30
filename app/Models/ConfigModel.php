<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model

{
    protected $table = 'config';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_desa', 'kode_desa', 'nama_kepala_desa', 'nip_kepala_desa', 'kode_pos',
        'email_desa', 'regid', 'macid', 'nama_kecamatan', 'kode_kecamatan',
        'nama_kepala_camat', 'nip_kepala_camat', 'nama_kabupaten', 'kode_kabupaten',
        'nama_propinsi', 'kode_propinsi', 'logo', 'lat', 'lng', 'zoom',
        'map_tipe', 'path', 'gapi_key', 'alamat_kantor', 'g_analytic'
    ];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
