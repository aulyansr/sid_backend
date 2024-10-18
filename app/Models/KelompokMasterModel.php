<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokMasterModel extends Model
{
    protected $table      = 'kelompok_master';
    protected $primaryKey = 'id';

    protected $allowedFields = ['kelompok', 'deskripsi'];
}
