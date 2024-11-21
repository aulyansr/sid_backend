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
        // Initialize the models
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

    // Index method: List all the records
    public function index($id_master)
    {
        // Return the view with the data
        $data['id_master'] = $id_master;
        return view('analisis_klasifikasi/index', $data);
    }

    // New method: Return the view to add a new record
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

    // Create method: Insert new record
    public function create()
    {
        // Get data from the request
        $data = $this->request->getPost();

        // Validate the required fields
        if (!$this->validate([
            'id_indikator' => 'required',
            'parameter'    => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ensure that 'id_indikator' and 'parameter' are arrays
        if (!is_array($data['id_indikator']) || !is_array($data['parameter'])) {
            return redirect()->back()->withInput()->with('errors', ['Invalid data structure.']);
        }

        $totalScoreint = (int) $data['total_score'];


        // Fetch klasifikasi based on the id_master and total_score range
        $klasifikasi = $this->analisisKlasifikasi
            ->where('id_master', $data['id_master'])
            ->where('minval <=', $totalScoreint)
            ->where('maxval >=', $totalScoreint)
            ->first();  // We expect only one record to match the range

        // Check if no klasifikasi is found
        if (!$klasifikasi) {
            return redirect()->back()->withInput()->with('errors', ['No matching klasifikasi for the total score.']);
        }

        // Now you can proceed with inserting the response data
        $idMaster     = $data['id_master'];
        $idSubject    = $data['id_subject'];          // Maps to id_subjek
        $idPeriode    = $data['id_periode'] ?? null;  // Optional field
        $indikatorIds = $data['id_indikator'];
        $parameters   = $data['parameter'];
        $total_score  = $data['total_score'];
        $tglUpdate    = date('Y-m-d H:i:s');


        // Prepare data for batch insertion
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

        // Insert into analisisResponHasil model
        if (!$this->analisisResponHasil->save([
            'id_master'  => $idMaster,
            'id_periode' => $idPeriode,
            'id_subjek'  => $idSubject,
            'tgl_update' => $tglUpdate,
            'akumulasi'  => $total_score,
        ])) {
            // If validation fails, get the validation errors
            $errors = $this->analisisResponHasil->errors();

            // Redirect back to the form with input data and errors
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // dd($klasifikasi['id']);
        // Save into analisisPartisipasi model
        if (!$this->analisisPartisipasi->save([
            'id_master'      => $idMaster,
            'id_periode'     => $idPeriode,
            'id_subjek'      => $idSubject,
            'id_klassifikasi' => $klasifikasi['id'],   // Ensure the correct id_klasifikasi is passed
        ])) {
            // If validation fails, get the validation errors
            $errors = $this->analisisPartisipasi->errors();

            // Redirect back to the form with input data and errors
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Insert into analisisRespon model
        if ($this->analisisRespon->insertBatch($dataToInsert)) {
            // Redirect to the index page with success message
            return redirect()->to('/admin/analisis_master/' . $idMaster . '/subjects')
                ->with('message', 'Analisis Respon added successfully.');
        } else {
            // Redirect back with database errors
            return redirect()->back()->withInput()->with('errors', $this->analisisRespon->errors());
        }
    }
}
