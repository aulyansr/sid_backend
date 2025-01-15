<?php

namespace App\Controllers;

use App\Models\DesaPamongModel;
use App\Models\DesaModel;

class DesaPamong extends BaseController
{
    protected $desaPamongModel;

    public function __construct()
    {
        $this->desaPamongModel = new DesaPamongModel();
    }

    public function index()
    {

        $currentUser = auth()->user();
        if ($currentUser->inGroup('superadmin')) {
            $data['desaPamongs'] = $this->desaPamongModel->findAll();
        } else {
            $data['desaPamongs'] = $this->desaPamongModel
                ->where('tweb_desa_pamong.desa_id', $currentUser->desa_id)
                ->findAll();
        }

        return view('desa_pamong/index', $data);
    }

    public function new()

    {
        $desaModel         = new DesaModel();
        $data['list_desa'] = $desaModel->findAll();
        return view('desa_pamong/new', $data);
    }

    public function create()
    {
        $postData = $this->request->getPost();
        if ($this->desaPamongModel->save($postData)) {
            return redirect()->to('/admin/pengurus')->with('success', 'Data has been successfully saved.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to save data.');
        }
    }

    public function show($id)
    {
        $data['pamong'] = $this->desaPamongModel->find($id);
        return view('desa_pamong/show', $data);
    }

    public function edit($id)
    {
        $data['pamong']    = $this->desaPamongModel->find($id);
        $desaModel         = new DesaModel();
        $data['list_desa'] = $desaModel->findAll();
        return view('desa_pamong/edit', $data);
    }

    public function update($id)
    {

        if ($this->desaPamongModel->update($id, $this->request->getPost())) {
            return redirect()->to('/admin/pengurus')->with('success', 'Data has been successfully updated.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update data.');
        }
    }

    public function delete($id)
    {
        $this->desaPamongModel->delete($id);
        return redirect()->to('/admin/pengurus');
    }
}
