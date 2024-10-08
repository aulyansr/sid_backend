<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table      = 'komentar';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_artikel', 'owner', 'email', 'komentar', 'tgl_upload', 'enabled'
    ];
}
