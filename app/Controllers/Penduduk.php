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


        $search = $this->request->getGet('search');


        if ($currentUser->inGroup('superadmin')) {
            $query = $this->pendudukModel->getAllAttributes();
        } else {
            $query = $this->pendudukModel
                ->where('desa_id', $currentUser->desa_id)
                ->getAllAttributes();
        }


        if (!empty($search)) {
            $query->groupStart()
                ->like("CAST(tweb_penduduk.nik AS TEXT)", $search)
                ->orLike('tweb_penduduk.nama', $search)
                ->groupEnd();
        }

        $data['penduduks'] = $query->findAll();


        $data['search']    = $search;
        $data['activeTab'] = 'penduduk';


        return view('penduduk/index', $data);
    }




    public function new()
    {

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
            'sexList' => $sexList,
            'pendidikanList' => $pendidikanList,
            'agamaList' => $agamaList,
            'pekerjaanList' => $pekerjaanList,
            'kawinList' => $kawinList,
            'hubunganList' => $hubunganList,
            'warganegaraList' => $warganegaraList,
            'golongandarahList' => $golongandarahList,
            'statusList' => $statusList,
            'cacatList' => $cacatList,
            'dusunList' => $dusunList
        ];

        return view('penduduk/new', $data);
    }

    public function create()
    {
        $postData                    = $this->request->getPost();
        $postData['dokumen_pasport'] = !empty($postData['dokumen_pasport']) ? $postData['dokumen_pasport'] : null;
        $postData['dokumen_kitas']   = !empty($postData['dokumen_kitas']) ? $postData['dokumen_kitas'] : null;

        $currentUser = auth()->user();
        $postData['desa_id'] = $currentUser->desa_id;



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

        $data['penduduk'] = $this->pendudukModel->find($id);


        $data['sexList'] = $this->db->table('tweb_penduduk_sex')->get()->getResultArray();
        $data['pendidikanList'] = $this->db->table('tweb_penduduk_pendidikan')->get()->getResultArray();
        $data['agamaList'] = $this->db->table('tweb_penduduk_agama')->get()->getResultArray();
        $data['pekerjaanList'] = $this->db->table('tweb_penduduk_pekerjaan')->get()->getResultArray();
        $data['kawinList'] = $this->db->table('tweb_penduduk_kawin')->get()->getResultArray();
        $data['hubunganList'] = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();
        $data['warganegaraList'] = $this->db->table('tweb_penduduk_warganegara')->get()->getResultArray();
        $data['golongandarahList'] = $this->db->table('tweb_golongan_darah')->get()->getResultArray();
        $data['statusList'] = $this->db->table('tweb_penduduk_status')->get()->getResultArray();
        $data['cacatList'] = $this->db->table('tweb_cacat')->get()->getResultArray();
        $data['dusunList'] = $this->wilayahModel->getDusun();


        return view('penduduk/edit', $data);
    }


    public function update($id)
    {

        $postData = $this->request->getPost();


        $postData['dokumen_pasport'] = !empty($postData['dokumen_pasport']) ? $postData['dokumen_pasport'] : null;
        $postData['dokumen_kitas']   = !empty($postData['dokumen_kitas']) ? $postData['dokumen_kitas'] : null;


        $this->pendudukModel->update($id, $postData);


        return redirect()->to('/admin/penduduk')->with('success', 'Data has been updated successfully.');
    }

    public function delete($id)
    {
        $this->pendudukModel->delete($id);
        return redirect()->to('/admin/penduduk');
    }
}
