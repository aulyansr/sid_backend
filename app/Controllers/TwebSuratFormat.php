<?php

namespace App\Controllers;

use App\Models\TwebSuratFormatModel;
use CodeIgniter\RESTful\ResourceController;

class TwebSuratFormat extends ResourceController
{
    protected $modelName = 'App\Models\TwebSuratFormatModel';
    protected $format    = 'json';

    public function index()
    {
        $data['tweb_surat_format'] = $this->model->findAll();
        return view('tweb_surat_format/index', $data);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return $this->failNotFound('Data not found');
        }
        return $this->respond($data);
    }

    public function create()
    {
        $input = $this->request->getPost();
        if (!$this->model->insert($input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return redirect()->to('/tweb_surat_format');
    }

    public function edit($id = null)
    {
        $data['tweb_surat_format'] = $this->model->find($id);
        return view('tweb_surat_format/edit', $data);
    }

    public function update($id = null)
    {
        $input = $this->request->getPost();
        if (!$this->model->update($id, $input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return redirect()->to('/tweb_surat_format');
    }

    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->failNotFound('Data not found');
        }
        return redirect()->to('/tweb_surat_format');
    }
}
