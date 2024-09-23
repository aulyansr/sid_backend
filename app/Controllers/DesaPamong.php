<?php

namespace App\Controllers;

use App\Models\DesaPamongModel;

class DesaPamong extends BaseController
{
    protected $desaPamongModel;

    public function __construct()
    {
        $this->desaPamongModel = new DesaPamongModel();
    }

    public function index()
    {
        $data['desaPamongs'] = $this->desaPamongModel->findAll();
        return view('desa_pamong/index', $data);
    }

    public function new()
    {
        return view('desa_pamong/new');
    }

    public function create()
    {
        $this->desaPamongModel->save($this->request->getPost());
        return redirect()->to('/admin/pengurus');
    }

    public function show($id)
    {
        $data['pamong'] = $this->desaPamongModel->find($id);
        return view('desa_pamong/show', $data);
    }

    public function edit($id)
    {
        $data['pamong'] = $this->desaPamongModel->find($id);
        return view('desa_pamong/edit', $data);
    }

    public function update($id)
    {
        $this->desaPamongModel->update($id, $this->request->getPost());
        return redirect()->to('/admin/pengurus');
    }

    public function delete($id)
    {
        $this->desaPamongModel->delete($id);
        return redirect()->to('/admin/pengurus');
    }
}
