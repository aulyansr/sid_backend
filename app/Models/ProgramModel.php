<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table      = 'program';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'ndesc', 'sasaran', 'sdate', 'edate', 'userID', 'rdate', 'status', 'pelaksana', 'id_sumber_dana'];

    const PENDUDUK = 1;
    const SUBJECT_KELUARGA = 2;
    const SUBJECT_RUMAH_TANGGA = 3;
    const SUBJECT_KELOMPOK = 4;
    const SUBJECT_DESA = 5;

    public function getTargets()
    {
        return [
            self::PENDUDUK => 'Penduduk Perorangan',
            self::SUBJECT_KELUARGA => 'Keluarga / KK',
            self::SUBJECT_RUMAH_TANGGA => 'Rumah Tangga',
            self::SUBJECT_KELOMPOK => 'Kelompok',
            self::SUBJECT_DESA => 'Desa',
        ];
    }
}
