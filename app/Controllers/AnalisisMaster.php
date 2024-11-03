<?php

namespace App\Controllers;

use App\Models\AnalisisMasterModel;

class AnalisisMaster extends BaseController
{
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisMasterModel = new AnalisisMasterModel();
    }

    public function index()
    {
        $data['analisis'] = $this->analisisMasterModel->findAll();
        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/index', $data);
    }

    public function new()
    {

        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['prelist'] = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children'] = $this->analisisMasterModel->findAll();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/new', $data);
    }

    public function create()
    {
        // Get the POST data
        $data = $this->request->getPost();

        if (empty($data['kode_analisis'])) {
            $data['kode_analisis'] = '0000';
        }

        // Save the data
        if ($this->analisisMasterModel->save($data)) {

            return redirect()->to('/admin/analisis_master')->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }


    public function edit($id)
    {
        $data['analisis'] = $this->analisisMasterModel->find($id);
        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['prelist'] = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children'] = $this->analisisMasterModel->findAll();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();
        return view('analisis_master/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // Attempt to update the record
        if ($this->analisisMasterModel->update($id, $data)) {
            // Update was successful, redirect to index
            return redirect()->to('/admin/analisis_master')->with('success', 'Analisis Master updated successfully.');
        } else {
            // Update failed, redirect back to the edit page with error messages
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }

    public function delete($id)
    {
        $this->analisisMasterModel->delete($id);
        return redirect()->to('/analisis_master');
    }
}
