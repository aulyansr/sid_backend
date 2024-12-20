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
        'tanggalperceraian',
        'desa_id',
    ];

    // Define validation rules if needed
    protected $validationRules = [
        'nama'                  => 'required|string|max_length[100]',
        'nik'                   => 'required|numeric|is_unique[tweb_penduduk.nik,id,{id}]',
        'kk_level'              => 'permit_empty|integer',
        'id_rtm'                => 'permit_empty|numeric',
        'rtm_level'             => 'permit_empty|integer',
        'sex'                   => 'required|in_list[1,2]',
        'tempatlahir'           => 'required|string|max_length[100]',
        'tanggallahir'          => 'required|valid_date[Y-m-d]',
        'agama_id'              => 'required|integer',
        'pendidikan_kk_id'      => 'permit_empty|integer',
        'pendidikan_id'         => 'permit_empty|integer',
        'pendidikan_sedang_id'  => 'permit_empty|integer',
        'pekerjaan_id'          => 'permit_empty|integer',
        'status_kawin'          => 'required|in_list[1,2,3,4]',
        'warganegara_id'        => 'required|integer',
        'dokumen_pasport'       => 'permit_empty|string|max_length[20]',
        'dokumen_kitas'         => 'permit_empty|string|max_length[20]',
        'ayah_nik'              => 'permit_empty|numeric',
        'ibu_nik'               => 'permit_empty|numeric',
        'nama_ayah'             => 'permit_empty|string|max_length[100]',
        'nama_ibu'              => 'permit_empty|string|max_length[100]',
        'foto'                  => 'permit_empty|string|max_length[255]',
        'golongan_darah_id'     => 'permit_empty|integer',
        'id_cluster'            => 'permit_empty|integer',
        'status'                => 'required|in_list[1,2,3]',
        'alamat_sebelumnya'     => 'permit_empty|string|max_length[255]',
        'alamat_sekarang'       => 'required|string|max_length[255]',
        'hamil'                 => 'permit_empty|in_list[1,0]',
        'cacat_id'              => 'permit_empty|integer',
        'sakit_menahun_id'      => 'permit_empty|integer',
        'jamkesmas'             => 'permit_empty|alpha_numeric|max_length[50]',
        'akta_lahir'            => 'permit_empty|string|max_length[50]',
        'akta_perkawinan'       => 'permit_empty|string|max_length[50]',
        'tanggalperkawinan'     => 'permit_empty|valid_date[Y-m-d]',
        'akta_perceraian'       => 'permit_empty|string|max_length[50]',
        'tanggalperceraian'     => 'permit_empty|valid_date[Y-m-d]',
        'desa_id'               => 'required|integer',
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

    public function getPendidikanSummary()
    {
        $query = $this->select('tweb_penduduk_pendidikan.nama AS kelompok, 
                                COUNT(tweb_penduduk.id) AS jumlah, 
                                SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki, 
                                SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan')
            ->join('tweb_penduduk_pendidikan', 'tweb_penduduk.pendidikan_id = tweb_penduduk_pendidikan.id', 'left')
            ->groupBy('tweb_penduduk_pendidikan.nama')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        $query[] = [
            'kelompok'         => 'TOTAL',
            'jumlah'           => $total,
            'persen'           => 100,
            'laki_laki'        => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2),
            'perempuan'        => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2),
        ];

        return $query;
    }

    public function getPendidikanTempuh()
    {
        $query = $this->select('tweb_penduduk_pendidikan.nama AS kelompok, 
                                COUNT(tweb_penduduk.id) AS jumlah, 
                                SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki, 
                                SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan')
            ->join('tweb_penduduk_pendidikan', 'tweb_penduduk.pendidikan_id = tweb_penduduk_pendidikan.id', 'left')
            ->groupBy('tweb_penduduk_pendidikan.nama')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        $query[] = [
            'kelompok' => 'TOTAL',
            'jumlah' => $total,
            'persen' => 100,
            'laki_laki' => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2),
            'perempuan' => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2),
        ];

        return $query;
    }

    public function getPekerjaan()
    {
        $query = $this->select('tweb_penduduk_pekerjaan.nama AS kelompok, 
                                COUNT(tweb_penduduk.id) AS jumlah, 
                                SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki, 
                                SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan')
            ->join('tweb_penduduk_pekerjaan', 'tweb_penduduk.pendidikan_id = tweb_penduduk_pekerjaan.id', 'left')
            ->groupBy('tweb_penduduk_pekerjaan.nama')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        $query[] = [
            'kelompok'         => 'TOTAL',
            'jumlah'           => $total,
            'persen'           => 100,
            'laki_laki'        => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => ($total != 0) ? round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2) : 0,   // Prevent division by zero
            'perempuan'        => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => ($total != 0) ? round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2) : 0,   // Prevent division by zero
        ];

        return $query;
    }

    public function getKelompokUmur()
    {
        // Menghitung umur berdasarkan tanggal lahir
        $query = $this->select('
            CASE
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 0 AND 5 THEN \'0-5\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 6 AND 11 THEN \'6-11\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 12 AND 17 THEN \'12-17\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 18 AND 23 THEN \'18-23\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 24 AND 29 THEN \'24-29\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 30 AND 35 THEN \'30-35\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 36 AND 41 THEN \'36-41\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 42 AND 47 THEN \'42-47\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 48 AND 53 THEN \'48-53\'
                WHEN EXTRACT(YEAR FROM AGE(tweb_penduduk.tanggallahir)) BETWEEN 54 AND 59 THEN \'54-59\'
                ELSE \'60+\'
            END AS kelompok_umur,
            COUNT(tweb_penduduk.id) AS jumlah,
            SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki,
            SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan
        ')
            ->groupBy('kelompok_umur')
            ->orderBy('kelompok_umur')
            ->get()
            ->getResultArray();

        // Total jumlah penduduk
        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        // Hitung persentase
        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        // Menambahkan total kelompok umur
        $query[] = [
            'kelompok_umur'         => 'TOTAL',
            'jumlah'           => $total,
            'persen'           => 100,
            'laki_laki'        => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => ($total != 0) ? round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2) : 0,   // Prevent division by zero
            'perempuan'        => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => ($total != 0) ? round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2) : 0,   // Prevent division by zero
        ];

        return $query;
    }

    public function getJenkel()
    {
        $query = $this->select('tweb_penduduk_sex.nama AS kelompok, 
                                COUNT(tweb_penduduk.id) AS jumlah, 
                                SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki, 
                                SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan')
            ->join('tweb_penduduk_sex', 'tweb_penduduk.pendidikan_id = tweb_penduduk_sex.id', 'left')
            ->groupBy('tweb_penduduk_sex.nama')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        $query[] = [
            'kelompok' => 'TOTAL',
            'jumlah' => $total,
            'persen' => 100,
            'laki_laki' => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => ($total != 0) ? round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2) : 0,  // Prevent division by zero
            'perempuan' => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => ($total != 0) ? round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2) : 0,  // Prevent division by zero
        ];

        return $query;
    }

    public function getAgama()
    {
        $query = $this->select('tweb_penduduk_agama.nama AS kelompok, 
                                COUNT(tweb_penduduk.id) AS jumlah, 
                                SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) AS laki_laki, 
                                SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) AS perempuan')
            ->join('tweb_penduduk_agama', 'tweb_penduduk.pendidikan_id = tweb_penduduk_agama.id', 'left')
            ->groupBy('tweb_penduduk_agama.nama')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();

        $total = array_reduce($query, fn($carry, $item) => $carry + $item['jumlah'], 0);

        foreach ($query as &$row) {
            $row['persen'] = round(($row['jumlah'] / $total) * 100, 2);
            $row['laki_laki_persen'] = round(($row['laki_laki'] / $total) * 100, 2);
            $row['perempuan_persen'] = round(($row['perempuan'] / $total) * 100, 2);
        }

        $query[] = [
            'kelompok' => 'TOTAL',
            'jumlah' => $total,
            'persen' => 100,
            'laki_laki' => array_sum(array_column($query, 'laki_laki')),
            'laki_laki_persen' => ($total != 0) ? round((array_sum(array_column($query, 'laki_laki')) / $total) * 100, 2) : 0,  // Prevent division by zero
            'perempuan' => array_sum(array_column($query, 'perempuan')),
            'perempuan_persen' => ($total != 0) ? round((array_sum(array_column($query, 'perempuan')) / $total) * 100, 2) : 0,  // Prevent division by zero
        ];

        return $query;
    }
}
