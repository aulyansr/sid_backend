<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramPesertaModel extends Model
{
    protected $table      = 'program_peserta';
    protected $primaryKey = 'id';

    // Allowed fields for insert or update
    protected $allowedFields = ['program_id', 'peserta', 'sasaran', 'userID', 'rdate'];

    public function getPenduduks()
    {
        return $this->select('program_peserta.*, tweb_penduduk.nama as penduduk_nama, tweb_penduduk.alamat_sekarang as penduduk_alamat')
            ->join('tweb_penduduk', 'program_peserta.peserta = tweb_penduduk.nik', 'left');
    }
}
