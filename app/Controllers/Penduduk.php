<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TwebPenduduk;
use App\Models\ClusterDesaModel;

class Penduduk extends BaseController
{
    protected $pendudukModel;
    protected $wilayahModel;
    protected $db;

    public function __construct()
    {
        // Initialize the model
        $this->pendudukModel = new TwebPenduduk();
        $this->wilayahModel = new ClusterDesaModel();
        // Initialize the database connection
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['activeTab'] = 'penduduk';
        $data['penduduks'] = $this->pendudukModel->getAllAttributes()->findAll();

        return view('penduduk/index', $data);
    }

    public function new()
    {
        // Fetch data from the database
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


        // Prepare data for the view
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
        $postData = $this->request->getPost();

        // Validate the data using the model's validation rules
        if (!$this->pendudukModel->save($postData)) {
            // If validation fails, get the validation errors
            $errors = $this->pendudukModel->errors();

            // Redirect back to the form with input data and errors
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors);
        }

        // If validation passes, redirect to the penduduk list
        return redirect()->to('/admin/penduduk')->with('success', 'Data has been saved successfully.');
    }


    public function edit($id)
    {
        // Fetch the specific penduduk record
        $data['penduduk'] = $this->pendudukModel->find($id);

        // Fetch data from the database
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

        // Prepare and return data for the view
        return view('penduduk/edit', $data);
    }


    public function update($id)
    {
        $this->pendudukModel->update($id, $this->request->getPost());
        return redirect()->to('/admin/penduduk');
    }

    public function delete($id)
    {
        $this->pendudukModel->delete($id);
        return redirect()->to('/admin/penduduk');
    }
}
