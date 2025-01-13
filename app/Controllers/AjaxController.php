<?php

namespace App\Controllers;

use App\Models\DesaPamongModel;
use App\Models\ClusterDesaModel;
use App\Models\TwebPenduduk;
use App\Models\KeluargaModel;

class AjaxController extends BaseController
{
    public function searchPamong()
    {
        $keyword = $this->request->getGet('q');
        $model = new DesaPamongModel();


        $results = $model->like('pamong_nip', $keyword, 'both', true)
            ->orLike('pamong_nama', $keyword, 'both', true)
            ->findAll();

        return $this->response->setJSON($results);
    }

    public function searchPenduduk()
    {
        $keyword = $this->request->getGet('q');
        $model = new TwebPenduduk();



        $results = $model->like('CAST(nik AS TEXT)', $keyword, 'both', true)
            ->orLike('nama', $keyword, 'both', true)
            ->findAll();

        return $this->response->setJSON($results);
    }

    public function getRW($dusunId)
    {
        $model = new ClusterDesaModel();
        $rwList = $model->getRW($dusunId);
        return $this->response->setJSON($rwList);
    }

    public function getRT($rwId)
    {
        $model = new ClusterDesaModel();
        $rtList = $model->getRT($rwId);
        return $this->response->setJSON($rtList);
    }

    public function search_kk()
    {
        $searchTerm = $this->request->getGet('q');
        $results = [];

        $model = new KeluargaModel();


        $kkRecords = $model
            ->select('tweb_keluarga.no_kk, tweb_keluarga.nik_kepala, tweb_penduduk.nama')
            ->join('tweb_penduduk', 'tweb_penduduk.nik = tweb_keluarga.nik_kepala')
            ->groupStart()
            ->like('CAST(tweb_keluarga.no_kk AS TEXT)', $searchTerm)
            ->orLike('CAST(tweb_keluarga.nik_kepala AS TEXT)', $searchTerm)
            ->orLike('tweb_penduduk.nama', $searchTerm)
            ->groupEnd()
            ->limit(10)
            ->findAll();


        foreach ($kkRecords as $kk) {
            $results[] = [
                'id' => $kk['no_kk'],
                'text' => $kk['no_kk'] . ' - ' . $kk['nik_kepala'] . ' - ' . $kk['nama']
            ];
        }


        return $this->response->setJSON($results);
    }

    public function penduduk(string $permalink = null)
    {
        $currentUser   = auth()->user();
        $pendudukModel = new TwebPenduduk();
        $filters       = $this->request->getGet();

        $statusKawin = $filters['status_kawin'] ?? [];
        $agama = $filters['agama'] ?? [];
        $goldar = $filters['goldar'] ?? [];
        $pendidikansdg = $filters['pendidikansdg'] ?? [];
        $pendidikankk = $filters['pendidikankk'] ?? [];
        $pekerjaan = $filters['pekerjaan'] ?? [];
        $wn = $filters['wn'] ?? [];
        $sdk = $filters['sdk'] ?? [];
        $start = $filters['start'] ?? 0;
        $length = $filters['length'] ?? 10;
        $orderColumn = $filters['order'][0]['column'] ?? 0;
        $orderDir = $filters['order'][0]['dir'] ?? 'asc';

        $columns = ['id', 'nik', 'nama', 'sex', 'tanggallahir', 'pendidikan_nama', 'pekerjaan_nama', 'kawin_nama'];
        $orderColumn = is_numeric($orderColumn) && isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'nik';

        $query = $pendudukModel;
        if (!$currentUser->inGroup('superadmin')) {
            $query->where('tweb_penduduk.desa_id', $currentUser->desa_id);
        }

        $filtersMap = [
            'tweb_penduduk.status_kawin' => $statusKawin,
            'tweb_penduduk.agama_id' => $agama,
            'tweb_penduduk.kk_level' => $sdk,
            'tweb_penduduk.pendidikan_kk_id' => $pendidikankk,
            'tweb_penduduk.pendidikan_id' => $pendidikansdg,
            'tweb_penduduk.pekerjaan_id' => $pekerjaan,
            'tweb_penduduk.warganegara_id' => $wn,
            'tweb_penduduk.golongan_darah_id' => $goldar,
        ];

        foreach ($filtersMap as $column => $values) {
            if (!empty($values)) {
                $query->whereIn($column, $values);
            }
        }

        $query->select('tweb_penduduk.*, 
        tweb_penduduk_sex.nama AS sex_nama, 
        tweb_penduduk_pendidikan.nama AS pendidikan_nama, 
        tweb_penduduk_pekerjaan.nama AS pekerjaan_nama, 
        tweb_penduduk_kawin.nama AS kawin_nama')
            ->join('tweb_penduduk_sex', 'tweb_penduduk.sex = tweb_penduduk_sex.id', 'left')
            ->join('tweb_penduduk_pendidikan', 'tweb_penduduk.pendidikan_kk_id = tweb_penduduk_pendidikan.id', 'left')
            ->join('tweb_penduduk_pekerjaan', 'tweb_penduduk.pekerjaan_id = tweb_penduduk_pekerjaan.id', 'left')
            ->join('tweb_penduduk_kawin', 'tweb_penduduk.status_kawin = tweb_penduduk_kawin.id', 'left');

        try {
            $totalRecords = $query->countAllResults(false);
            $penduduks = $query->orderBy($orderColumn, $orderDir)->findAll($length, $start);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }

        $data = [];
        foreach ($penduduks as $index => $penduduk) {
            $age = (new \DateTimeImmutable($penduduk['tanggallahir']))->diff(new \DateTimeImmutable())->y;
            $row = [
                'id' => esc($penduduk['id']),
                'no' => $start + $index + 1,
                'nik' => esc($penduduk['nik']),
                'nama' => esc($penduduk['nama']),
                'sex' => esc($penduduk['sex'] == '1' ? 'L' : 'P'),
                'age' => $age,
                'tanggallahir' => esc($penduduk['tanggallahir']),
                'pendidikan_nama' => esc($penduduk['pendidikan_nama'] ?? 'N/A'),
                'pekerjaan_nama' => esc($penduduk['pekerjaan_nama'] ?? 'N/A'),
                'kawin_nama' => esc($penduduk['kawin_nama'] ?? 'N/A'),
            ];
            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw' => $filters['draw'] ?? 1,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }
}
