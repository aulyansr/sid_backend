<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisParameterModel extends Model
{
    protected $table = 'analisis_parameter';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_indikator',
        'kode_jawaban',
        'asign',
        'jawaban',
        'nilai',
    ];
    protected $useTimestamps = false;
}
