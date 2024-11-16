<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisResponModel extends Model
{
    protected $table = 'analisis_respon';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_indikator', 'id_parameter', 'id_subjek', 'id_periode'];
}
