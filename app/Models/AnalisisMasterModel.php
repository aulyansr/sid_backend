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

    public function getSubjectsWithStatus($subject_type, $id_master)
    {
        // Depending on the subject_type, you join with the relevant table (penduduk, keluarga, kelompok)

        if ($subject_type == 1) {
            // For subject_type 1, join with the 'tweb_penduduk' table
            $subjects = $this->db->table('tweb_penduduk')
                ->select('tweb_penduduk.*,
                tweb_penduduk.nik AS parameter_subject,
                tweb_penduduk.nama as subject_nama, 
             CASE 
                 WHEN analisis_respon_hasil.id_subjek IS NULL THEN \'belum_mengisi\' 
                 ELSE \'mengisi\' 
             END AS status, 
             COALESCE(analisis_respon_hasil.tgl_update, NULL) AS tanggal_update')
                ->join('analisis_respon_hasil', 'analisis_respon_hasil.id_subjek = tweb_penduduk.nik', 'left')
                ->where('analisis_respon_hasil.id_master', $id_master)
                ->orWhere('analisis_respon_hasil.id_subjek IS NULL')
                ->get()->getResultArray();
        } elseif ($subject_type == 2) {
            // For subject_type 2, join with the 'tweb_keluarga' table
            $subjects =
                $this->db->table('tweb_keluarga')
                ->select('tweb_keluarga.*, 
                  tweb_keluarga.no_kk AS parameter_subject,
                  tweb_penduduk.nama AS subject_nama, 
                  CASE 
                      WHEN analisis_respon_hasil.id_subjek IS NULL THEN \'belum_mengisi\' 
                      ELSE \'mengisi\' 
                  END AS status, 
                  COALESCE(analisis_respon_hasil.tgl_update, NULL) AS tanggal_update')
                ->join('analisis_respon_hasil', 'analisis_respon_hasil.id_subjek = tweb_keluarga.no_kk', 'left')
                ->join('tweb_penduduk', 'tweb_penduduk.nik = tweb_keluarga.nik_kepala', 'left')
                ->groupStart()
                ->where('analisis_respon_hasil.id_master', $id_master)
                ->orWhere('analisis_respon_hasil.id_subjek IS NULL')
                ->groupEnd()
                ->get()->getResultArray();
        } elseif ($subject_type == 3) {
            // For subject_type 3, join with the 'kelompok_master' table
            $subjects =
                $this->db->table('kelompok_master')
                ->select('kelompok_master.*, 
             CASE 
                 WHEN analisis_respon_hasil.id_subjek IS NULL THEN \'belum_mengisi\' 
                 ELSE \'mengisi\' 
             END AS status, 
             COALESCE(analisis_respon_hasil.tgl_update, NULL) AS tanggal_update')
                ->join('analisis_respon_hasil', 'analisis_respon_hasil.id_subjek = kelompok_master.nik', 'left')
                ->where('analisis_respon_hasil.id_master', $id_master)
                ->orWhere('analisis_respon_hasil.id_subjek IS NULL')
                ->get()->getResultArray();
        }

        return $subjects;
    }
    public function getReportAttributes()
    {
        return $this->db->table('tweb_penduduk')
            ->select(
                'tweb_penduduk.*, 
                  tweb_penduduk_sex.nama AS sex_nama,analisis_klasifikasi.nama AS klasifikasi_nama'
            )
            ->join('analisis_partisipasi', 'analisis_partisipasi.id_subjek = tweb_penduduk.nik', 'left')
            ->join('tweb_penduduk_sex', 'tweb_penduduk.sex = tweb_penduduk_sex.id', 'left')
            ->join('analisis_klasifikasi', 'analisis_klasifikasi.id = analisis_partisipasi.id_klassifikasi', 'left')
            ->join('analisis_master', 'analisis_master.id = analisis_partisipasi.id_master', 'left');  // Add this join for analisis_master
        // Return the result as an array
    }

    public function categories()
    {
        return $this->hasMany('App\Models\AnalisisKategoriIndikatorModel', 'master_id', 'id');
    }

    public function indikators()
    {
        return $this->hasMany('App\Models\AnalisisIndikatorModel', 'master_id', 'id');
    }
}
