<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table = 'surat';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor_surat', 'nama', 'nik', 'jenis_surat', 'keperluan'];
    protected $useTimestamps = true;
}
