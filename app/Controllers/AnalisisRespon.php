<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnalisisKlasifikasiModel;
use App\Models\AnalisisMasterModel;
use App\Models\AnalisisParameterModel;
use App\Models\AnalisisIndikatorModel;
use App\Models\AnalisisKategoriIndikatorModel;
use App\Models\AnalisisResponModel;

class AnalisisRespon extends BaseController
{
    protected $analisisKlasifikasi;
    protected $analisisMasterModel;
    protected $analisisParameter;
    protected $analisisIndikatorModel;
    protected $analisisKategori;
    protected $analisisRespon;

    public function __construct()
    {
        // Initialize the model
        $this->analisisKlasifikasi = new AnalisisKlasifikasiModel();
        $this->analisisMasterModel = new AnalisisMasterModel();
        $this->analisisIndikatorModel = new AnalisisIndikatorModel();
        $this->analisisKategori = new AnalisisKategoriIndikatorModel();
        $this->analisisParameter = new AnalisisParameterModel();
        $this->analisisRespon = new AnalisisResponModel();
    }

    // Index method: List all the records
    public function index($id_master)
    {



        // Return the view with the data
        return view('analisis_klasifikasi/index', $data);
    }

    // New method: Return the view to add a new record
    public function new($id_master)
    {
        $data['id_master'] = $id_master;
        return view('analisis_respon/new', $data);
    }

    // Create method: Insert new record
    public function create()
    {
        // Get data from the request
        $data = $this->request->getPost();

        // Save data to the database
        if ($this->analisisKlasifikasi->save($data)) {
            // Redirect to the index page with success message
            return redirect()->to('/admin/analisis_master/' . $data['id_master'] . '/analisis-klasifikasi')
                ->with('message', 'Analisis Klasifikasi added successfully.');
        } else {
            // Redirect back with validation errors
            return redirect()->back()->withInput()->with('errors', $this->analisisKlasifikasi->errors());
        }
    }

    // Edit method: Show the edit form for a specific record
    public function edit($id)
    {
        // Retrieve the record to be edited
        $data['analisisKlasifikasi'] = $this->analisisKlasifikasi->find($id);

        // Return the edit view with the data
        return view('analisis_klasifikasi/edit', $data);
    }

    // Update method: Update a specific record
    public function update($id)
    {
        // Get the updated data from the request
        $data = $this->request->getPost();

        // Update the record in the database
        $this->analisisKlasifikasi->update($id, $data);

        // Redirect back to the index page
        return redirect()->to('/admin/analisis-klasifikasi?id_master=' . $data['id_master']);
    }

    // Delete method: Delete a specific record
    public function delete($id)
    {
        // Retrieve the record to get the id_master
        $analisisKlasifikasi = $this->analisisKlasifikasi->find($id);
        $id_master = $analisisKlasifikasi['id_master'];

        // Delete the record from the database
        $this->analisisKlasifikasi->delete($id);

        // Redirect back to the index page
        return redirect()->to('/admin/analisis_master/' . $id_master . '/analisis-klasifikasi');
    }
}
