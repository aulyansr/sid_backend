<?php

namespace App\Models;

use CodeIgniter\Model;

class DesaPamongModel extends Model
{
    protected $table = 'tweb_desa_pamong';
    protected $primaryKey = 'pamong_id';
    protected $allowedFields = [
        'pamong_nama',
        'pamong_nip',
        'pamong_nik',
        'jabatan',
        'pamong_status',
        'pamong_tgl_terdaftar'
    ];
}
