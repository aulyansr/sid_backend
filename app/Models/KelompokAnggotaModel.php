<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokAnggotaModel extends Model
{
    protected $table = 'kelompok_anggota';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id_kelompok', 'id_penduduk'];

    public function get_all_attributes($id_kelompok = null)
    {
        $builder = $this->db->table($this->table)
            ->select('kelompok_anggota.id, kelompok_anggota.id_kelompok, kelompok_anggota.id_penduduk,tweb_penduduk.*')
            ->join('tweb_penduduk', 'tweb_penduduk.nik = kelompok_anggota.id_penduduk', 'left');

        // Optional filter by id_kelompok
        if ($id_kelompok !== null) {
            $builder->where('kelompok_anggota.id_kelompok', $id_kelompok);
        }

        return $builder->get()->getResultArray();
    }
}
