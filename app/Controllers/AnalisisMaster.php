<?php

namespace App\Controllers;

use App\Models\AnalisisMasterModel;
use App\Models\AnalisisParameterModel;
use App\Models\AnalisisIndikatorModel;
use App\Models\AnalisisKategoriIndikatorModel;
use App\Models\AnalisisResponModel;
use App\Models\AnalisisResponHasilModel;
use App\Models\AnalisisPeriodeModel;
use App\Models\AnalisisPartisipasiModel;
use App\Models\AnalisisKlasifikasiModel;
use App\Models\DesaModel;

class AnalisisMaster extends BaseController
{
    protected $analisisPeriodeModel;
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisMasterModel = new AnalisisMasterModel();
        $this->analisisPeriodeModel = new AnalisisPeriodeModel();
    }

    public function index(string $permalink = null)
    {
        $desaModel   = new DesaModel();
        $currentUser = auth()->user();

        if ($currentUser->inGroup('superadmin')) {
            $data['analisis'] = $this->analisisMasterModel->findAll();
        } else {
            $data['analisis'] = $this->analisisMasterModel
                ->where('desa_id', $currentUser->desa_id)
                ->findAll();
        }


        $data['subjects'] = $this->analisisMasterModel->getSubjects();
        $data['lockOptions'] = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/index', $data);
    }

    public function new()
    {
        $desaModel                = new DesaModel();
        $data['list_desa']        = $desaModel->findAll();
        $data['subjects']         = $this->analisisMasterModel->getSubjects();
        $data['prelist']          = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children']         = $this->analisisMasterModel->findAll();
        $data['lockOptions']      = $this->analisisMasterModel->getLockOptions();

        return view('analisis_master/new', $data);
    }

    public function create()
    {

        $data                = $this->request->getPost();
        $currentUser         = auth()->user();
        $data['subjek_tipe'] = 1;

        if (empty($data['kode_analisis'])) {
            $data['kode_analisis'] = '0000';
        }

        if ($this->analisisMasterModel->save($data)) {

            return redirect()->to('/admin/analisis_master')->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisMasterModel->errors());
        }
    }


    public function edit($id)
    {
        $desaModel                = new DesaModel();
        $data['list_desa']        = $desaModel->findAll();
        $data['analisis']         = $this->analisisMasterModel->find($id);
        $data['subjects']         = $this->analisisMasterModel->getSubjects();
        $data['prelist']          = $this->analisisMasterModel->getPrelistOptions();
        $data['fitur_pembobotan'] = $this->analisisMasterModel->getFiturPembobotanOptions();
        $data['children']         = $this->analisisMasterModel->findAll();
        $data['lockOptions']      = $this->analisisMasterModel->getLockOptions();
        return view('analisis_master/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();


        if ($this->analisisMasterModel->update($id, $data)) {
            return redirect()->to('/admin/analisis_master')->with('success', 'Analisis Master updated successfully.');
        } else {
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
        $klasifikasi             = new AnalisisKlasifikasiModel();
        if (!$klasifikasi->where('id_master', $id_master)->first()) {
            return redirect()->back()->withInput()->with('errors', 'Klasifikasi belum ada');
        }

        $subject_type = $data['analisis_master']['subjek_tipe'];

        $data['subjects'] = $this->analisisMasterModel->getSubjectsWithStatus($subject_type, $id_master);

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();

        if (!$data['periode']) {
            return redirect()->back()->withInput()->with('errors', 'Periode belum ada');
        }

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

        return view('analisis_master/subjects', $data);
    }

    public function reports($id_master)
    {
        $data['activeTab'] = "report";

        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);

        $subject_type = $data['analisis_master']['subjek_tipe'];

        $data['subjects'] = $this->analisisMasterModel->getReportAttributes()->where('analisis_master.id', $id_master)->get()->getResult();

        $klasifikasi             = new AnalisisKlasifikasiModel();
        if (!$klasifikasi->where('id_master', $id_master)->first()) {
            return redirect()->back()->withInput()->with('errors', 'Klasifikasi belum ada');
        }

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();

        if (!$data['periode']) {
            return redirect()->back()->withInput()->with('errors', 'Periode belum ada');
        }

        return view('analisis_master/report', $data);
    }
}
