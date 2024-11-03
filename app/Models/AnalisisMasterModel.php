<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalisisMasterModel extends Model
{
    protected $table      = 'analisis_master';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama',
        'subjek_tipe',
        'lock',
        'fitur_prelist',
        'deskripsi',
        'kode_analisis',
        'id_child',
        'id_kelompok',
        'pembagi',
        'fitur_pembobotan',
    ];

    protected $validationRules = [
        'nama'              => 'required|max_length[40]',
        'subjek_tipe'      => 'required|integer',
        'lock'              => 'required|integer',
        'fitur_prelist'    => 'required|integer',
        'kode_analisis'    => 'required|max_length[5]',
        'pembagi'          => 'decimal|permit_empty',
    ];

    // Define constants for categories
    const SUBJECT_PENDUDUK = 1;
    const SUBJECT_KELUARGA = 2;
    const SUBJECT_RUMAH_TANGGA = 3;
    const SUBJECT_KELOMPOK = 4;
    const SUBJECT_DESA = 5;

    const PRELIST_YA = 1;
    const PRELIST_TIDAK = 0;

    const FITUR_PEMBOBOTAN_YA = 1;
    const FITUR_PEMBOBOTAN_TIDAK = 0;

    const LOCK_UNLOCKED = 1; // Tidak Terkunci
    const LOCKED = 2;       // Terkunci

    // Optional: Method to get the list of categories
    public function getSubjects()
    {
        return [
            self::SUBJECT_PENDUDUK => 'Penduduk',
            self::SUBJECT_KELUARGA => 'Keluarga / KK',
            self::SUBJECT_RUMAH_TANGGA => 'Rumah Tangga',
            self::SUBJECT_KELOMPOK => 'Kelompok',
            self::SUBJECT_DESA => 'Desa',
        ];
    }

    public function getPrelistOptions()
    {
        return [
            self::PRELIST_YA => 'Ya',
            self::PRELIST_TIDAK => 'Tidak',
        ];
    }

    public function getFiturPembobotanOptions()
    {
        return [
            self::FITUR_PEMBOBOTAN_YA => 'Ya',
            self::FITUR_PEMBOBOTAN_TIDAK => 'Tidak',
        ];
    }

    public function getLockOptions()
    {
        return [
            self::LOCK_UNLOCKED => 'Tidak Terkunci',
            self::LOCKED => 'Terkunci',
        ];
    }
}
