<?php

namespace App\Models;

use CodeIgniter\Model;

class TwebPenduduk extends Model
{
    protected $table = 'tweb_penduduk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    // Specify which fields can be set during insert/update
    protected $allowedFields = [
        'nama',
        'nik',
        'id_kk',
        'kk_level',
        'id_rtm',
        'rtm_level',
        'sex',
        'tempatlahir',
        'tanggallahir',
        'agama_id',
        'pendidikan_kk_id',
        'pendidikan_id',
        'pendidikan_sedang_id',
        'pekerjaan_id',
        'status_kawin',
        'warganegara_id',
        'dokumen_pasport',
        'dokumen_kitas',
        'ayah_nik',
        'ibu_nik',
        'nama_ayah',
        'nama_ibu',
        'foto',
        'golongan_darah_id',
        'id_cluster',
        'status',
        'alamat_sebelumnya',
        'alamat_sekarang',
        'status_dasar',
        'hamil',
        'cacat_id',
        'sakit_menahun_id',
        'jamkesmas',
        'akta_lahir',
        'akta_perkawinan',
        'tanggalperkawinan',
        'akta_perceraian',
        'tanggalperceraian'
    ];

    // Define validation rules if needed
    protected $validationRules = [
        'nik' => 'required|numeric',
        'nama' => 'required|string|max_length[100]',
        'tanggallahir' => 'valid_date[Y-m-d]',
    ];

    public function getAllAttributes()
    {
        return $this->select('tweb_penduduk.*, 
                          tweb_penduduk_sex.nama AS sex_nama, 
                          tweb_penduduk_pendidikan.nama AS pendidikan_nama, 
                          tweb_penduduk_agama.nama AS agama_nama, 
                          tweb_penduduk_pekerjaan.nama AS pekerjaan_nama, 
                          tweb_penduduk_kawin.nama AS kawin_nama, 
                          tweb_penduduk_hubungan.nama AS hubungan_nama, 
                          tweb_penduduk_warganegara.nama AS warganegara_nama, 
                          tweb_golongan_darah.nama AS golongan_darah_nama, 
                          tweb_penduduk_status.nama AS status_nama, 
                          tweb_cacat.nama AS cacat_nama')
            ->join('tweb_penduduk_sex', 'tweb_penduduk.sex = tweb_penduduk_sex.id', 'left')
            ->join('tweb_penduduk_pendidikan', 'tweb_penduduk.pendidikan_kk_id = tweb_penduduk_pendidikan.id', 'left')
            ->join('tweb_penduduk_agama', 'tweb_penduduk.agama_id = tweb_penduduk_agama.id', 'left')
            ->join('tweb_penduduk_pekerjaan', 'tweb_penduduk.pekerjaan_id = tweb_penduduk_pekerjaan.id', 'left')
            ->join('tweb_penduduk_kawin', 'tweb_penduduk.status_kawin = tweb_penduduk_kawin.id', 'left')
            ->join('tweb_penduduk_hubungan', 'tweb_penduduk.kk_level = tweb_penduduk_hubungan.id', 'left')
            ->join('tweb_penduduk_warganegara', 'tweb_penduduk.warganegara_id = tweb_penduduk_warganegara.id', 'left')
            ->join('tweb_golongan_darah', 'tweb_penduduk.golongan_darah_id = tweb_golongan_darah.id', 'left')
            ->join('tweb_penduduk_status', 'tweb_penduduk.status = tweb_penduduk_status.id', 'left')
            ->join('tweb_cacat', 'tweb_penduduk.cacat_id = tweb_cacat.id', 'left');
    }
}
