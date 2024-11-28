<?php

namespace App\Controllers;

use App\Models\AnalisisIndikatorModel;
use App\Models\AnalisisMasterModel;
use App\Models\AnalisisKategoriIndikatorModel;

class AnalisisIndikator extends BaseController
{
    protected $analisisIndikatorModel;
    protected $analisisMasterModel;
    protected $analisisKategori;


    public function __construct()
    {
        $this->analisisMasterModel = new AnalisisMasterModel();
        $this->analisisIndikatorModel = new AnalisisIndikatorModel();
        $this->analisisKategori = new AnalisisKategoriIndikatorModel();
    }


    public function index($id_master)
    {
        $data['activeTab'] = "settings";
        $data['activeSideTab'] = "indikator";
        $data['indikator_categories'] = $this->analisisIndikatorModel->getBaseAttributes()->where('analisis_indikator.id_master', $id_master)->findAll();
        $data['question_type'] = $this->analisisIndikatorModel->getQuestionType();
        $data['act_analisis'] = $this->analisisIndikatorModel->getActAnalisisOptions();
        $data['required'] = $this->analisisIndikatorModel->getRequiredOptions();
        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);
        return view('analisis_indikator/index', $data);
    }


    public function new($id_master)

    {
        $data['id_master'] = $id_master;
        $data['question_type'] = $this->analisisIndikatorModel->getQuestionType();
        $data['act_anlisis'] = $this->analisisIndikatorModel->getActAnalisisOptions();
        $data['required'] = $this->analisisIndikatorModel->getRequiredOptions();
        $data['indikator_categories'] = $this->analisisKategori->where('id_master', $id_master)->findAll();
        return view('analisis_indikator/new', $data);
    }


    public function create()
    {
        $data = $this->request->getPost();

        if (empty($data['is_statistik'])) {
            $data['is_statistik'] = 1;
        }


        // Save the data
        if ($this->analisisIndikatorModel->save($data)) {
            return redirect()->to('/admin/analisis_master/' .  $data['id_master'] . '/analisis-indikators')->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }


    public function edit($id)
    {
        $data['indikator'] = $this->analisisIndikatorModel->find($id);
        if (empty($data['indikator'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data not found');
        }
        return view('analisis_indikator/edit', $data);
    }


    public function update($id)
    {
        $indikator = $this->analisisIndikatorModel->find($id);
        $this->analisisIndikatorModel->update($id, [
            'id_master' => $this->request->getPost('id_master'),
            'nomor' => $this->request->getPost('nomor'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'id_tipe' => $this->request->getPost('id_tipe'),
            'bobot' => $this->request->getPost('bobot'),
            'act_analisis' => $this->request->getPost('act_analisis'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'is_publik' => $this->request->getPost('is_publik'),
            'is_statistik' => $this->request->getPost('is_statistik'),
            'is_required' => $this->request->getPost('is_required'),
        ]);
        return redirect()->to('/admin/analisis_master/' . $indikator['id_master'] . '/analisis-indikators');
    }


    public function delete($id)
    {
        $analisisIndikatorModel = $this->analisisIndikatorModel->find($id);
        $analisis_master_id = $analisisIndikatorModel['id_master'];
        $this->analisisIndikatorModel->delete($id);
        return redirect()->to('admin/analisis_master/' . $analisis_master_id . '/analisis-indikators');
    }
}
