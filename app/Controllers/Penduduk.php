<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TwebPenduduk;
use App\Models\ClusterDesaModel;
use App\Models\SuratModel;
use App\Models\DesaModel;


class Penduduk extends BaseController
{
    protected $suratModel;
    protected $pendudukModel;
    protected $wilayahModel;
    protected $db;

    public function __construct()
    {

        $this->pendudukModel = new TwebPenduduk();
        $this->suratModel = new SuratModel();
        $this->wilayahModel = new ClusterDesaModel();

        $this->db = \Config\Database::connect();
    }

    public function index(string $permalink = null)
    {
        $desaModel   = new DesaModel();
        $currentUser = auth()->user();

        $desa         = $desaModel->where('permalink', $permalink)->first();
        $data['desa'] = $desa;

        $data['request'] = $this->request;

        $data['sexList']           = $this->db->table('tweb_penduduk_sex')->get()->getResultArray();
        $data['pendidikanList']    = $this->db->table('tweb_penduduk_pendidikan')->get()->getResultArray();
        $data['agamaList']         = $this->db->table('tweb_penduduk_agama')->get()->getResultArray();
        $data['pekerjaanList']     = $this->db->table('tweb_penduduk_pekerjaan')->get()->getResultArray();
        $data['kawinList']         = $this->db->table('tweb_penduduk_kawin')->get()->getResultArray();
        $data['hubunganList']      = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();
        $data['warganegaraList']   = $this->db->table('tweb_penduduk_warganegara')->get()->getResultArray();
        $data['golongandarahList'] = $this->db->table('tweb_golongan_darah')->get()->getResultArray();
        $data['statusList']        = $this->db->table('tweb_penduduk_status')->get()->getResultArray();
        $data['cacatList']         = $this->db->table('tweb_cacat')->get()->getResultArray();
        $data['dusunList']         = $this->wilayahModel->getDusun();

        $filters = $this->request->getGet();
        $search  = $filters['search'] ?? null;

        $data['search']    = $search;
        $data['activeTab'] = 'penduduk';

        return view('penduduk/index', $data);
    }

    public function filterPenduduks(array $filters, $query)
    {

        if (!empty($filters['sdk'])) {
            $query->whereIn('tweb_penduduk_hubungan.id', $filters['sdk']);
        }

        if (!empty($filters['sex'])) {
            $query->whereIn('tweb_penduduk.sex', $filters['sex']);
        }


        if (!empty($filters['pendidikankk'])) {
            $query->whereIn('tweb_penduduk.pendidikan_kk_id', $filters['pendidikankk']);
        }

        if (!empty($filters['pendidikansdg'])) {
            $query->whereIn('tweb_penduduk.pendidikan_sedang_id', $filters['pendidikansdg']);
        }


        if (!empty($filters['agama'])) {
            $query->whereIn('tweb_penduduk.agama_id', $filters['agama']);
        }


        if (!empty($filters['pekerjaan'])) {
            $query->whereIn('tweb_penduduk.pekerjaan_id', $filters['pekerjaan']);
        }


        if (!empty($filters['hubungan'])) {
            $query->whereIn('tweb_penduduk.hubungan_id', $filters['hubungan']);
        }


        if (!empty($filters['stskwn'])) {
            $query->whereIn('tweb_penduduk.status_kawin', $filters['stskwn']);
        }

        if (!empty($filters['wn'])) {
            $query->whereIn('tweb_penduduk.warganegara_id', $filters['wn']);
        }


        if (!empty($filters['goldar'])) {
            $query->whereIn('tweb_penduduk.golongan_darah_id', $filters['goldar']);
        }



        return $query;
    }





    public function new()
    {


        $desaModel    = new DesaModel();

        $sexList = $this->db->table('tweb_penduduk_sex')->get()->getResultArray();
        $pendidikanList = $this->db->table('tweb_penduduk_pendidikan')->get()->getResultArray();
        $agamaList = $this->db->table('tweb_penduduk_agama')->get()->getResultArray();
        $pekerjaanList = $this->db->table('tweb_penduduk_pekerjaan')->get()->getResultArray();
        $kawinList = $this->db->table('tweb_penduduk_kawin')->get()->getResultArray();
        $hubunganList = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();
        $warganegaraList = $this->db->table('tweb_penduduk_warganegara')->get()->getResultArray();
        $golongandarahList = $this->db->table('tweb_golongan_darah')->get()->getResultArray();
        $statusList = $this->db->table('tweb_penduduk_status')->get()->getResultArray();
        $cacatList = $this->db->table('tweb_cacat')->get()->getResultArray();
        $dusunList =  $this->wilayahModel->getDusun();



        $data = [
            'sexList'           => $sexList,
            'pendidikanList'    => $pendidikanList,
            'agamaList'         => $agamaList,
            'pekerjaanList'     => $pekerjaanList,
            'kawinList'         => $kawinList,
            'hubunganList'      => $hubunganList,
            'warganegaraList'   => $warganegaraList,
            'golongandarahList' => $golongandarahList,
            'statusList'        => $statusList,
            'cacatList'         => $cacatList,
            'dusunList'         => $dusunList,
            'list_desa'    => $desaModel->findAll()
        ];

        return view('penduduk/new', $data);
    }

    public function create()
    {
        $postData                    = $this->request->getPost();
        $postData['dokumen_pasport'] = !empty($postData['dokumen_pasport']) ? $postData['dokumen_pasport'] : null;
        $postData['dokumen_kitas']   = !empty($postData['dokumen_kitas']) ? $postData['dokumen_kitas'] : null;
$postData['id_rtm']   = !empty($postData['id_rtm']) ? $postData['dokumen_kitas'] : 0;
$postData['rtm_level']   = !empty($postData['id_rtm']) ? $postData['rtm_level'] : 0;
$postData['pendidikan_id']   = !empty($postData['pendidikan_sedang_id']) ? $postData['pendidikan_sedang_id'] : 0;
$postData['foto']   = !empty($postData['foto']) ? $postData['foto'] : "a";
$postData['golongan_darah_id']   = !empty($postData['golongan_darah_id']) ? $postData['golongan_darah_id'] : 0;
$postData['status_dasar']   = !empty($postData['status_dasar']) ? $postData['status_dasar'] : 0;
$postData['sakit_menahun_id']   = !empty($postData['sakit_menahun_id']) ? $postData['sakit_menahun_id'] : 0;
$postData['jamkesmas']   = !empty($postData['jamkesmas']) ? $postData['jamkesmas'] : 0;
$postData['akta_perkawinan']   = !empty($postData['akta_perkawinan']) ? $postData['akta_perkawinan'] : "aa";
$postData['tanggalperkawinan'] = !empty($postData['tanggalperkawinan']) ? 
    $postData['tanggalperkawinan'] : date('Y-m-d');

$postData['akta_perceraian']   = !empty($postData['akta_perceraian']) ? $postData['akta_perceraian'] : 'aa';
$postData['tanggalperceraian']   = !empty($postData['tanggalperceraian']) ? $postData['tanggalperceraian'] : '1973-08-08';

        $currentUser = auth()->user();

        if (!$this->pendudukModel->save($postData)) {

            $errors = $this->pendudukModel->errors();


            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }


        return redirect()->to('/admin/penduduk')->with('success', 'Data has been saved successfully.');
    }

    public function show($id)
    {

        $penduduk = $this->pendudukModel->getAllAttributes()->find($id);


        if (!$penduduk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Penduduk not found');
        }


        $wilayah = $this->wilayahModel->where('id', $penduduk['id_cluster'])->first();


        if ($wilayah) {
            $rw = $this->wilayahModel->where('id', $wilayah['parent'])->first();
            $dusun = $this->wilayahModel->where('id', $rw['parent'])->first();
        } else {
            $rw = null;
            $dusun = null;
        }

        $surat_keluar  = $this->suratModel->where('nik', $penduduk['nik'])->findAll();


        return view('penduduk/show', [
            'penduduk' => $penduduk,
            'wilayah' => $wilayah,
            'rw' => $rw,
            'dusun' => $dusun,
            'surat_keluar' => $surat_keluar
        ]);
    }


    public function edit($id)
    {

        $desaModel    = new DesaModel();

        $data['penduduk'] = $this->pendudukModel->find($id);


        $data['sexList']           = $this->db->table('tweb_penduduk_sex')->get()->getResultArray();
        $data['pendidikanList']    = $this->db->table('tweb_penduduk_pendidikan')->get()->getResultArray();
        $data['agamaList']         = $this->db->table('tweb_penduduk_agama')->get()->getResultArray();
        $data['pekerjaanList']     = $this->db->table('tweb_penduduk_pekerjaan')->get()->getResultArray();
        $data['kawinList']         = $this->db->table('tweb_penduduk_kawin')->get()->getResultArray();
        $data['hubunganList']      = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();
        $data['warganegaraList']   = $this->db->table('tweb_penduduk_warganegara')->get()->getResultArray();
        $data['golongandarahList'] = $this->db->table('tweb_golongan_darah')->get()->getResultArray();
        $data['statusList']        = $this->db->table('tweb_penduduk_status')->get()->getResultArray();
        $data['cacatList']         = $this->db->table('tweb_cacat')->get()->getResultArray();
        $data['dusunList']         = $this->wilayahModel->getDusun();
        $data['list_desa']         = $desaModel->findAll();


        return view('penduduk/edit', $data);
    }


    public function update($id)
    {

        $postData = $this->request->getPost();


        $postData['dokumen_pasport'] = !empty($postData['dokumen_pasport']) ? $postData['dokumen_pasport'] : null;
        $postData['dokumen_kitas']   = !empty($postData['dokumen_kitas']) ? $postData['dokumen_kitas'] : null;


        if ($this->pendudukModel->update($id, $postData)) {
            return redirect()->to('/admin/penduduk')->with('success', 'Data has been updated successfully.');
        } else {
            $errors = $this->pendudukModel->errors();


            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }
    }

    public function delete($id)
    {
        $this->pendudukModel->delete($id);
        return redirect()->to('/admin/penduduk');
    }
}
