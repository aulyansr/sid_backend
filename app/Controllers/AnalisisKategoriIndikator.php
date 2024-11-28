<?php

namespace App\Controllers;

use App\Models\AnalisisKategoriIndikatorModel;
use App\Models\AnalisisMasterModel;


class AnalisisKategoriIndikator extends BaseController
{
    protected $analisisKategori;
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisKategori = new AnalisisKategoriIndikatorModel();
        $this->analisisMasterModel = new AnalisisMasterModel();
    }

    public function index($id_master)
    {
        $data['activeTab']     = "settings";
        $data['activeSideTab'] = "kategori";

        $data['analisisCategories'] = $this->analisisKategori
            ->where('id_master', $id_master)
            ->findAll();
        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);
        $data['analisis']        = $this->analisisMasterModel->find($id_master);

        return view('analisis_kategori/index', $data);
    }

    public function new($id_master)
    {
        $data['id_master'] = $id_master;

        return view('analisis_kategori/new', $data);
    }

    public function create()
    {

        $data = $this->request->getPost();


        if ($this->analisisKategori->save($data)) {

            return redirect()->to('/admin/analisis_master/' .  $data['id_master'] . '/kategori-indikators')->with('message', 'Analisis added successfully.');
        } else {
            dd("as");
            return redirect()->back()->withInput()->with('errors', $this->analisisKategori->errors());
        }
    }


    public function edit($id)
    {
        $data['analisisKategori'] = $this->analisisKategori->find($id);
        return view('analisis_kategori/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $analisisKategori = $this->analisisKategori->find($id);


        if ($this->analisisKategori->update($id, $data)) {

            return redirect()->to('/admin/analisis_master/' .  $analisisKategori['id_master'] . '/kategori-indikators')->with('message', 'Analisis added successfully.');
        } else {

            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }

    public function delete($id)
    {
        $analisisKategori = $this->analisisKategori->find($id);
        $analisis_master_id = $analisisKategori['id_master'];
        $this->analisisKategori->delete($id);
        return redirect()->to('admin/analisis_master/' . $analisis_master_id . '/kategori-indikators');
    }


    public function show($id)
    {
        $data['categories'] = $this->analisisMasterModel->findAll();
        return view('analisis_master/index', $data);
    }
}
