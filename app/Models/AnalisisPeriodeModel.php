<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisPeriodeModel extends Model
{
    protected $table      = 'analisis_periode';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_master',
        'nama',
        'id_state',
        'aktif',
        'keterangan',
        'tahun_pelaksanaan'
    ];


    const BELUM = 1;
    const SEDANG = 2;
    const SELESAI = 3;

    const ACTIVE_YA = 1;
    const ACTIVE_TIDAK = 2;

    public function getStateType()
    {
        return [
            self::BELUM => 'Belum Pendataan / Input',
            self::SEDANG => 'Sedang Pendataan / Input',
            self::SELESAI => 'Selesai Pelaksanaan',
        ];
    }

    public function getActiveOptions()
    {
        return [
            self::ACTIVE_YA => 'Ya',
            self::ACTIVE_TIDAK => 'Tidak'
        ];
    }
}
