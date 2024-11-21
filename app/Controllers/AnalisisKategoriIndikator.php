<?php

namespace App\Controllers;

use App\Models\AnalisisKategoriIndikatorModel;
use App\Models\AnalisisMasterModel;


class AnalisisKategoriIndikator extends BaseController
{
    protected $analisisKategori;
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisKategori = new AnalisisKategoriIndikatorModel();
        $this->analisisMasterModel = new AnalisisMasterModel();
    }

    public function index($id_master)
    {
        $data['activeTab'] = "settings";
        $data['activeSideTab'] = "kategori";
        $data['analisisCategories'] = $this->analisisKategori
            ->where('id_master', $id_master)
            ->findAll();
        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);
        $data['analisis'] = $this->analisisMasterModel->find($id_master);

        return view('analisis_kategori/index', $data);
    }

    public function new($id_master)
    {
        $data['id_master'] = $id_master;

        return view('analisis_kategori/new', $data);
    }

    public function create()
    {
        // Get the POST data
        $data = $this->request->getPost();

        // Save the data
        if ($this->analisisKategori->save($data)) {

            return redirect()->to('/admin/analisis_master')->with('message', 'Analisis added successfully.');
        } else {
            dd("as");
            return redirect()->back()->withInput()->with('errors', $this->analisisKategori->errors());
        }
    }


    public function edit($id)
    {
        $data['analisisKategori'] = $this->analisisKategori->find($id);
        return view('analisis_kategori/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // Attempt to update the record
        if ($this->analisisKategori->update($id, $data)) {
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

    public function show($id)
    {
        $data['categories'] = $this->analisisMasterModel->findAll();
        return view('analisis_master/index', $data);
    }
}
