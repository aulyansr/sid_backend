<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnalisisKlasifikasiModel;
use App\Models\AnalisisMasterModel;
use App\Models\AnalisisParameterModel;
use App\Models\AnalisisIndikatorModel;
use App\Models\AnalisisKategoriIndikatorModel;
use App\Models\AnalisisResponModel;
use App\Models\AnalisisResponHasilModel;
use App\Models\AnalisisPeriodeModel;
use App\Models\AnalisisPartisipasiModel;

class AnalisisRespon extends BaseController
{
    protected $analisisKlasifikasi;
    protected $analisisMasterModel;
    protected $analisisParameter;
    protected $analisisIndikatorModel;
    protected $analisisKategori;
    protected $analisisRespon;
    protected $analisisResponHasil;
    protected $analisisPeriodeModel;

    protected $analisisPartisipasi;

    public function __construct()
    {

        $this->analisisKlasifikasi    = new AnalisisKlasifikasiModel();
        $this->analisisMasterModel    = new AnalisisMasterModel();
        $this->analisisIndikatorModel = new AnalisisIndikatorModel();
        $this->analisisKategori       = new AnalisisKategoriIndikatorModel();
        $this->analisisParameter      = new AnalisisParameterModel();
        $this->analisisRespon         = new AnalisisResponModel();
        $this->analisisResponHasil    = new AnalisisResponHasilModel();
        $this->analisisPeriodeModel   = new AnalisisPeriodeModel();
        $this->analisisPartisipasi    = new AnalisisPartisipasiModel();
    }


    public function index($id_master)
    {

        $data['id_master'] = $id_master;
        return view('analisis_klasifikasi/index', $data);
    }


    public function new($id_master, $subject)
    {
        $indikatorModel             = new AnalisisIndikatorModel();
        $analisisParameter          = new AnalisisParameterModel();
        $data['id_master']          = $id_master;
        $data['subject']            = $subject;
        $data['analisis_master']    = $this->analisisMasterModel->find($id_master);
        $data['analisisCategories'] = $this->analisisKategori
            ->where('id_master', $id_master)
            ->findAll();

        $data['indikators'] = $indikatorModel;
        $data['parameters'] = $analisisParameter;

        $data['periode'] = $this->analisisPeriodeModel
            ->where('id_master', $id_master)
            ->orderBy('tahun_pelaksanaan', 'desc')
            ->first();
        return view('analisis_respon/new', $data);
    }


    public function create()
    {

        $data = $this->request->getPost();


        if (!$this->validate([
            'id_indikator' => 'required',
            'parameter'    => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        if (!is_array($data['id_indikator']) || !is_array($data['parameter'])) {
            return redirect()->back()->withInput()->with('errors', ['Invalid data structure.']);
        }

        $totalScoreint = (int) $data['total_score'];



        $klasifikasi = $this->analisisKlasifikasi
            ->where('id_master', $data['id_master'])
            ->where('minval <=', $totalScoreint)
            ->where('maxval >=', $totalScoreint)
            ->first();


        if (!$klasifikasi) {
            return redirect()->back()->withInput()->with('errors', ['No matching klasifikasi for the total score.']);
        }


        $idMaster     = $data['id_master'];
        $idSubject    = $data['id_subject'];
        $idPeriode    = $data['id_periode'] ?? null;
        $indikatorIds = $data['id_indikator'];
        $parameters   = $data['parameter'];
        $total_score  = $data['total_score'];
        $tglUpdate    = date('Y-m-d H:i:s');



        $dataToInsert = [];
        foreach ($indikatorIds as $indikatorId) {
            if (!empty($parameters[$indikatorId])) {
                $dataToInsert[] = [
                    'id_indikator' => $indikatorId,
                    'id_parameter' => $parameters[$indikatorId],
                    'id_subjek'    => $idSubject,
                    'id_periode'   => $idPeriode,
                    'tgl_update'   => $tglUpdate,
                ];
            }
        }

        if (empty($dataToInsert)) {
            return redirect()->back()->withInput()->with('errors', ['No valid data to save.']);
        }


        if (!$this->analisisResponHasil->save([
            'id_master'  => $idMaster,
            'id_periode' => $idPeriode,
            'id_subjek'  => $idSubject,
            'tgl_update' => $tglUpdate,
            'akumulasi'  => $total_score,
        ])) {

            $errors = $this->analisisResponHasil->errors();


            return redirect()->back()->withInput()->with('errors', $errors);
        }



        if (!$this->analisisPartisipasi->save([
            'id_master'      => $idMaster,
            'id_periode'     => $idPeriode,
            'id_subjek'      => $idSubject,
            'id_klassifikasi' => $klasifikasi['id'],
        ])) {

            $errors = $this->analisisPartisipasi->errors();


            return redirect()->back()->withInput()->with('errors', $errors);
        }


        if ($this->analisisRespon->insertBatch($dataToInsert)) {

            return redirect()->to('/admin/analisis_master/' . $idMaster . '/subjects')
                ->with('message', 'Analisis Respon added successfully.');
        } else {

            return redirect()->back()->withInput()->with('errors', $this->analisisRespon->errors());
        }
    }

    public function reset($id_master, $subject)
    {

        $analisisRespon = new AnalisisResponModel();
        $analisisResponHasil = new AnalisisResponHasilModel();
        $analisisPartisipasi = new AnalisisPartisipasiModel();
        $analisisindikator   = new AnalisisIndikatorModel();


        $db = \Config\Database::connect();
        $db->transBegin();

        try {


            $analisisResponHasil->where('id_master', $id_master)
                ->where('id_subjek', $subject)
                ->delete();

            $analisisPartisipasi->where('id_master', $id_master)
                ->where('id_subjek', $subject)
                ->delete();

            $analisisIndikatorIds = $analisisindikator->select('id')
                ->where('id_master', $id_master)
                ->findAll();


            $idList = array_map('intval', array_column($analisisIndikatorIds, 'id'));


            $analisisRespon->whereIn('id_indikator', $idList)
                ->where('id_subjek', $subject)
                ->delete();

            $db->transCommit();
            return redirect()->to('/admin/analisis_master/' . $id_master . '/subjects');
        } catch (\Exception $e) {

            $db->transRollback();
            throw $e;
            return redirect()->back()->withInput()->with('errors', $this->analisisRespon->errors());
        }
    }
}
