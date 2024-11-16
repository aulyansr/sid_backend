<?php

namespace App\Controllers;

use App\Models\ProgramModel;
use App\Models\ProgramPesertaModel;

class ProgramController extends BaseController
{
    protected $programModel;
    protected $programPesertaModel;
    protected $db;

    public function __construct()
    {
        $this->programModel = new ProgramModel();
        $this->programPesertaModel = new ProgramPesertaModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil semua data program
        $data['programs'] = $this->programModel->findAll();
        $data['targets'] = $this->programModel->getTargets();
        return view('program/index', $data);
    }

    public function new()
    {
        $data['sumberdanaList'] = $this->db->table('program_sumber_dana')->get()->getResultArray();
        $data['targets'] = $this->programModel->getTargets();
        return view('program/new', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->programModel->save($data)) {
            return redirect()->to('/program')->with('message', 'Program created successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->programModel->errors());
        }
    }

    public function show($id)
    {
        $data['programModel'] = $this->programModel->find($id);
        $data['participants'] = $this->programPesertaModel
            ->getPenduduks()
            ->where('program_peserta.program_id', $id)
            ->findAll();
        $data['targets'] = $this->programModel->getTargets();
        return view('program/show', $data);
    }

    public function edit($id)
    {
        $data['programModel'] = $this->programModel->find($id);
        $data['sumberdanaList'] = $this->db->table('program_sumber_dana')->get()->getResultArray();
        $data['targets'] = $this->programModel->getTargets();
        return view('program/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->programModel->update($id, $data)) {
            return redirect()->to('/admin/program')->with('message', 'Program updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->programModel->errors());
        }
    }

    public function delete($id)
    {
        $this->programPesertaModel = new ProgramPesertaModel();
        return redirect()->to('/admin/program')->with('message', 'Program deleted successfully.');
    }

    public function add_peserta($id)
    {
        $data = $this->request->getPost();

        if ($this->programPesertaModel->save($data)) {

            return redirect()->to('/admin/program')->with('message', 'Program created successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->programModel->errors());
        }
    }
}
