<?php

namespace App\Controllers;

use App\Models\DesaModel;

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
        $data['villages'] = $this->desaModel->findAll();
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
        $data['desa'] = $this->desaModel->find($id);
        return view('desa/edit', $data);
    }

    // Update the desa data
    public function update($id)
    {



        $this->desaModel->update($id, [
            'nama_desa' => $this->request->getPost('nama_desa'),
            'permalink' => $this->request->getPost('permalink'),
        ]);

        return redirect()->to('admin/desa');
    }

    // Delete the desa
    public function delete($id)
    {
        $this->desaModel->delete($id);
        return redirect()->to('/desa');
    }
}
