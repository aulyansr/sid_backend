<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisResponHasilModel extends Model
{
    protected $table = 'analisis_respon_hasil'; // The name of the table
    protected $primaryKey = 'id'; // The primary key column
    protected $allowedFields = [
        'id_master',
        'id_periode',
        'id_subjek',
        'akumulasi',
        'tgl_update',
    ]; // The fields that are allowed to be inserted or updated
    protected $useTimestamps = false; // If you want to manage timestamps manually
    protected $returnType = 'array'; // You can set this to 'object' if you want it to return objects
    protected $useSoftDeletes = false; // Set to true if you plan to use soft deletes

    // Validation rules for the model


    // Optional: You can define custom methods here if you need more functionality
}
