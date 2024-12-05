<?php

namespace App\Controllers;

use App\Models\KelurahanModel;
use App\Models\desaModel;
use SawaStacks\CodeIgniter\Slugify;

class Kelurahan extends BaseController
{
    protected $kelurahanModel;
    protected $desaModel;

    public function __construct()
    {
        $this->kelurahanModel = new kelurahanModel();
        $this->desaModel = new desaModel();
    }

    // Display the list of desa
    public function index()
    {
        $data['kelurahans'] = $this->kelurahanModel->getKecamatan()->findAll();
        return view('kelurahan/index', $data);
    }

    // Show the form for creating a new desa
    public function create()
    {
        $data['villages'] = $this->desaModel->findAll();
        return view('kelurahan/create', $data);
    }

    // Store the new desa data
    public function store()
    {


        $data = $this->request->getPost();



        if ($this->kelurahanModel->save($data)) {

            return redirect()->to('admin/kelurahan');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->kelurahanModel->errors());
        }
    }

    // Show the form for editing the desa
    public function edit($id)
    {
        $data['kelurahan'] = $this->kelurahanModel->find($id);
        $data['villages'] = $this->desaModel->findAll();
        return view('kelurahan/edit', $data);
    }

    // Update the desa data
    public function update($id)
    {
        // Get the form data
        $data = $this->request->getPost();

        // Attempt to update the record in the database
        if ($this->kelurahanModel->update($id, $data)) {
            // If the update is successful, redirect with a success message
            return redirect()->to('admin/kelurahan')->with('success', 'Record updated successfully.');
        } else {
            // If the update fails, redirect with an error message
            return redirect()->to('admin/kelurahan')->with('error', $this->kelurahanModel->errors());
        }
    }


    // Delete the desa
    public function delete($id)
    {
        $this->kelurahanModel->delete($id);
        return redirect()->to('/admin/kelurahan');
    }
}
