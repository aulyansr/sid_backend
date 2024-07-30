<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModulModel extends Model
{
    protected $table = 'setting_modul';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'modul', 'url', 'aktif', 'ikon', 'urut', 'level', 'hidden'
    ];
    protected $useTimestamps = true;
}
