<?php

namespace App\Controllers;

use App\Models\KelompokMasterModel;

class KelompokMaster extends BaseController
{
    protected $kelompokMasterModel;

    public function __construct()
    {
        $this->kelompokMasterModel = new KelompokMasterModel();
    }

    // Display list of Kelompok Masters
    public function index()
    {
        $data['activeTab'] = 'kelompok';
        $data['kelompok_masters'] = $this->kelompokMasterModel->findAll();
        return view('kelompok_master/index', $data);
    }

    // Display form to create a new Kelompok Master
    public function new()
    {
        return view('kelompok_master/create');
    }

    // Save new Kelompok Master
    public function create()
    {
        $this->kelompokMasterModel->save([
            'kelompok'  => $this->request->getPost('kelompok'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/master-kelompok')->with('message', 'Kelompok Master successfully created.');
    }

    // Display specific Kelompok Master details
    public function show($id)
    {
        $data['kelompok_master'] = $this->kelompokMasterModel->find($id);
        return view('kelompok_master/show', $data);
    }

    // Display form to edit Kelompok Master
    public function edit($id)
    {
        $data['kelompokMaster'] = $this->kelompokMasterModel->find($id);
        return view('kelompok_master/edit', $data);
    }

    // Update Kelompok Master
    public function update($id)
    {
        $this->kelompokMasterModel->update($id, [
            'kelompok'  => $this->request->getPost('kelompok'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin/master-kelompok')->with('message', 'Kelompok Master successfully updated.');
    }

    // Delete Kelompok Master
    public function delete($id)
    {
        $this->kelompokMasterModel->delete($id);
        return redirect()->to('/admin/master-kelompok')->with('message', 'Kelompok Master successfully deleted.');
    }
}
