<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnalisisParameterModel;
use App\Models\AnalisisIndikatorModel;

class AnalisisParameter extends BaseController
{
    protected $analisisParameter;
    protected $analisisIndikatorModel;

    public function __construct()
    {
        $this->analisisParameter = new AnalisisParameterModel();
        $this->analisisIndikatorModel = new AnalisisIndikatorModel();
    }

    public function index()
    {
        $indikatorId = request()->getGet('id_indikator');
        $data['analisa_parameters'] = $this->analisisParameter
            ->where('id_indikator', $indikatorId)
            ->findAll();
        $analisisIndikator = $this->analisisIndikatorModel->find($indikatorId);
        $data['analisis_master'] = $analisisIndikator['id_master'];

        return view('analisis_parameter/index', $data);
    }

    public function new()
    {
        return view('analisis_parameter/new');
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->analisisParameter->save($data)) {

            return redirect()->to('/admin/analisis-parameter?id_indikator=' . $data['id_indikator'])->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisParameter->errors());
        }
    }

    public function edit($id)
    {
        $data['analisisParameter'] = $this->analisisParameter->find($id);
        return view('analisis_parameter/edit', $data);
    }

    public function update($id)
    {
        $this->analisisParameter->update($id, $this->request->getPost());
        return redirect()->to('/analisis-parameter');
    }

    public function delete($id)
    {
        $analisisParameter = $this->analisisParameter->find($id);
        $indikator_id = $analisisParameter['id_indikator'];
        $this->analisisParameter->delete($id);
        return redirect()->to('/admin/analisis-parameter?id_indikator=' . $indikator_id);
    }
}
