<?php

namespace App\Controllers;

use App\Models\DesaModel;
use App\Models\KecamatanModel;
use SawaStacks\CodeIgniter\Slugify;

class Desa extends BaseController
{
    protected $desaModel;

    public function __construct()
    {
        $this->desaModel = new DesaModel();
    }

    // Display the list of desa
    public function index()
    {
        $data['villages'] = $this->desaModel->get_desa_with_config()->findAll();
        return view('desa/index', $data);
    }

    // Show the form for creating a new desa
    public function create()
    {
        return view('desa/create');
    }

    // Store the new desa data
    public function store()
    {


        $data = $this->request->getPost();



        if ($this->desaModel->save($data)) {

            return redirect()->to('admin/desa');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->desaModel->errors());
        }
    }

    // Show the form for editing the desa
    public function edit($id)
    {
        $list_kecamatan         = new KecamatanModel();
        $data['list_kecamatan'] = $list_kecamatan->findAll();
        $data['desa']           = $this->desaModel->find($id);
        return view('desa/edit', $data);
    }

    // Update the desa data
    public function update($id)
    {
        // Get the form data
        $data = $this->request->getPost();

        // Attempt to update the record in the database
        if ($this->desaModel->update($id, $data)) {
            // If the update is successful, redirect with a success message
            return redirect()->to('admin/desa')->with('success', 'Record updated successfully.');
        } else {
            // If the update fails, redirect with an error message
            return redirect()->to('admin/desa')->with('error', $this->desaModel->errors());
        }
    }


    // Delete the desa
    public function delete($id)
    {
        $this->desaModel->delete($id);
        return redirect()->to('/desa');
    }
}
