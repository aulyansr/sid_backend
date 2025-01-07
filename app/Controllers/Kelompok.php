<?php

namespace App\Controllers;

use App\Models\KelompokModel;
use App\Models\KelompokMasterModel;
use App\Models\KelompokAnggotaModel;
use App\Models\TwebPenduduk;

class Kelompok extends BaseController
{
    protected $kelompokModel;
    protected $kelompokMasterModel;
    protected $kelompokAnggotaModel;
    protected $pendudukModel;
    protected $db;

    public function __construct()
    {
        $this->kelompokModel = new KelompokModel();
        $this->pendudukModel = new TwebPenduduk();
        $this->kelompokMasterModel = new KelompokMasterModel();
        $this->kelompokAnggotaModel = new KelompokAnggotaModel();
        $this->db = \Config\Database::connect();
    }

    // Display list of Kelompok
    public function index()
    {
        $data['activeTab'] = 'kelompok';
        $currentUser = auth()->user();
        if ($currentUser->inGroup('superadmin')) {
            $data['kelompok']  = $this->kelompokModel->get_all_attributes();
        } else {
            $data['kelompok'] = $this->kelompokModel
                ->where('kelompok.desa_id', $currentUser->desa_id)
                ->get_all_attributes();
        }

        return view('kelompok/index', $data);
    }

    // Display form to create a new Kelompok
    public function new()
    {
        $data['kelompokMasters'] = $this->kelompokMasterModel->findAll();
        return view('kelompok/new', $data);
    }

    public function create()
    {
        // Begin a transaction to ensure data integrity
        $this->db->transBegin();

        // Save Kelompok data to the kelompok table
        $kelompokData = [
            'id_master'  => $this->request->getPost('id_master'),
            'id_ketua'   => $this->request->getPost('id_ketua'),
            'kode'       => $this->request->getPost('kode'),
            'nama'       => $this->request->getPost('nama'),
            'keterangan' => $this->request->getPost('keterangan'),
            'desa_id' => $this->request->getPost('desa_id'),
        ];

        // Insert kelompok data
        $this->kelompokModel->save($kelompokData);

        // Get the ID of the newly created kelompok
        $id_kelompok = $this->kelompokModel->getInsertID();

        // Retrieve anggota_kelompok data from the request
        $anggota_kelompok = $this->request->getPost('anggota_kelompok');

        // Save each anggota (family member) to the kelompok_anggota table
        if (!empty($anggota_kelompok)) {
            foreach ($anggota_kelompok as $anggota) {
                $anggotaData = [
                    'id_kelompok' => $id_kelompok,
                    'id_penduduk' => $anggota['nik'], // Assuming 'nik' is provided in the form for each anggota
                ];

                // Save anggota to kelompok_anggota table
                $this->kelompokAnggotaModel->save($anggotaData);
            }
        }

        // Check if transaction was successful
        if ($this->db->transStatus() === FALSE) {
            // Rollback the transaction if something went wrong
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Failed to create Kelompok.');
        } else {
            // Commit the transaction if everything went well
            $this->db->transCommit();
            return redirect()->to('admin/kelompok')->with('message', 'Kelompok successfully created.');
        }
    }
    // Display specific Kelompok details
    public function show($id)
    {
        $data['kelompok'] = $this->kelompokModel->find($id);
        $data['kelompokMaster'] = $this->kelompokMasterModel->find($data['kelompok']['id_master']);
        $data['kepalakelompok'] = $this->pendudukModel->where('nik', $data['kelompok']['id_ketua'])->first();
        $data['anggota_kelompok'] = $this->kelompokAnggotaModel->get_all_attributes($id);

        return view('kelompok/show', $data);
    }

    // Display form to edit Kelompok
    public function edit($id)
    {
        // Find the Kelompok by ID
        $kelompok = $this->kelompokModel->find($id);

        // Check if Kelompok exists
        if (!$kelompok) {
            return redirect()->back()->with('error', 'Data kelompok tidak ditemukan.');
        }

        // Fetch all Kelompok Masters
        $kelompokMasters = $this->kelompokMasterModel->findAll();

        // Fetch Ketua data based on id_ketua from the kelompok record
        $ketua = $this->pendudukModel->where('nik', $kelompok['id_ketua'])->first();

        // Fetch anggota list based on id_kelompok from the kelompok_anggota table
        $anggotaList = $this->kelompokAnggotaModel->get_all_attributes($id);


        // Pass data to the view
        return view('kelompok/edit', [
            'kelompok' => $kelompok,
            'kelompokMasters' => $kelompokMasters,
            'ketua' => $ketua,
            'anggotaList' => $anggotaList
        ]);
    }

    public function update($id)
    {
        $postData = $this->request->getPost();

        // Start database transaction
        $this->db->transBegin();

        // Update kelompok data
        $kelompokData = [
            'id_master'   => $this->request->getPost('id_master'),
            'id_ketua'    => $this->request->getPost('id_ketua'),
            'kode'        => $this->request->getPost('kode'),
            'nama'        => $this->request->getPost('nama'),
            'keterangan'  => $this->request->getPost('keterangan'),
        ];

        // Attempt to update kelompok, rollback on failure
        if (!$this->kelompokModel->update($id, $kelompokData)) {
            $this->db->transRollback();
            $errors = $this->kelompokModel->errors();
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Delete existing anggota_kelompok records for this kelompok
        if (!$this->kelompokAnggotaModel->where('id_kelompok', $id)->delete()) {
            // Rollback if deleting existing anggota_kelompok fails
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('errors', 'Failed to delete anggota_kelompok.');
        }

        // Retrieve anggota_kelompok data from the request
        $anggota_kelompok = $this->request->getPost('anggota_kelompok');

        // Save each anggota (family member) to the kelompok_anggota table
        if (!empty($anggota_kelompok)) {
            foreach ($anggota_kelompok as $anggota) {
                $anggotaData = [
                    'id_kelompok' => $id,
                    'id_penduduk' => $anggota['nik'], // Assuming 'nik' is provided in the form for each anggota
                ];

                // Save anggota to kelompok_anggota table
                $this->kelompokAnggotaModel->save($anggotaData);
            }
        }

        // If all went well, commit the transaction
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return redirect()->back()->withInput()->with('errors', 'Terjadi kesalahan dalam memperbarui data.');
        } else {
            $this->db->transCommit();
            // Redirect with success message
            return redirect()->to(base_url('admin/kelompok'))->with('message', 'Data kelompok berhasil diperbarui.');
        }
    }


    // Delete Kelompok
    public function delete($id)
    {
        $this->kelompokModel->delete($id);
        return redirect()->to('admin/kelompok')->with('message', 'Kelompok successfully deleted.');
    }
}
