<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisPartisipasiModel extends Model
{
    protected $table = 'analisis_partisipasi';
    protected $primaryKey = 'id';

    // Allowed fields for insertion/updating
    protected $allowedFields = ['id_subjek', 'id_master', 'id_periode', 'id_klassifikasi'];

    // If you want to use timestamps, set this to true

}
