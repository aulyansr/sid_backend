<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisKategoriIndikatorModel extends Model
{
    protected $table = 'analisis_kategori_indikator';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_master', 'kategori_kode', 'kategori'];
}
