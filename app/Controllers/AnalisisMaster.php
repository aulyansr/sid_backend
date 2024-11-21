<?php

namespace App\Controllers;

use App\Models\AnalisisMasterModel;
use App\Models\AnalisisPeriodeModel;

class AnalisisMaster extends BaseController
{
    protected $analisisPeriodeModel;
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisMasterModel = new AnalisisMasterModel();
        $this->analisisPeriodeModel = new AnalisisPeriodeModel();
    }

    public function index()
    {

        $data['analisis'] = $this->analisisMasterModel->findAll();
        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/index', $data);
    }

    public function new()
    {

        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['prelist'] = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children'] = $this->analisisMasterModel->findAll();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/new', $data);
    }

    public function create()
    {
        // Get the POST data
        $data = $this->request->getPost();

        if (empty($data['kode_analisis'])) {
            $data['kode_analisis'] = '0000';
        }

        // Save the data
        if ($this->analisisMasterModel->save($data)) {

            return redirect()->to('/admin/analisis_master')->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }


    public function edit($id)
    {
        $data['analisis'] = $this->analisisMasterModel->find($id);
        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['prelist'] = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children'] = $this->analisisMasterModel->findAll();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();
        return view('analisis_master/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        // Attempt to update the record
        if ($this->analisisMasterModel->update($id, $data)) {
            // Update was successful, redirect to index
            return redirect()->to('/admin/analisis_master')->with('success', 'Analisis Master updated successfully.');
        } else {
            // Update failed, redirect back to the edit page with error messages
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }

    public function delete($id)
    {
        $this->analisisMasterModel->delete($id);
        return redirect()->to('/analisis_master');
    }

    public function show($id)
    {
        $data['categories'] = $this->analisisMasterModel->findAll();
        return view('analisis_master/index', $data);
    }

    public function showSubjects($id_master)
    {
        $data['activeTab'] = "input";

        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);

        $subject_type = $data['analisis_master']['subjek_tipe'];

        $data['subjects'] = $this->analisisMasterModel->getSubjectsWithStatus($subject_type, $id_master);

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();

        // Pass the data to the view
        return view('analisis_master/subjects', $data);
    }

    public function inputSubjects($id_master, $id_subject)
    {

        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);
        $data['subject'] = $id_subject;

        $subject_type = $data['analisis_master']['subjek_tipe'];

        $data['subjects'] = $this->analisisMasterModel->getSubjectsWithStatus($subject_type, $id_master);
        $data['subjects_types'] = $this->analisisMasterModel->getSubjects();

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();

        // Pass the data to the view
        return view('analisis_master/subjects', $data);
    }

    public function reports($id_master)
    {
        $data['activeTab'] = "input";

        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);

        $subject_type = $data['analisis_master']['subjek_tipe'];

        $data['subjects'] = $this->analisisMasterModel->getReportAttributes() // Get the query builder
            ->where('id', $id_master) // Apply the where condition after
            ->get()->getResult();

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();

        // Pass the data to the view
        return view('analisis_master/subjects', $data);
    }
}
