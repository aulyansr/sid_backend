<?php

namespace App\Controllers;

use App\Models\AnalisisPeriodeModel;
use App\Models\AnalisisMasterModel;

class AnalisisPeriode extends BaseController
{
    protected $analisisPeriodeModel;
    protected $analisisMasterModel;

    public function __construct()
    {
        $this->analisisPeriodeModel = new AnalisisPeriodeModel();
        $this->analisisMasterModel = new AnalisisMasterModel();
    }

    public function index($id_master)
    {
        $data['analisisPeriode'] = $this->analisisPeriodeModel->where('id_master', $id_master)
            ->findAll();
        $data['activeTab'] = "settings";
        $data['activeSideTab'] = "periode";
        $data['state_type'] = $this->analisisPeriodeModel->getStateType();
        $data['active_type'] = $this->analisisPeriodeModel->getActiveOptions();
        $data['analisis_master'] = $this->analisisMasterModel->find($id_master);
        $id_master = request()->getGet('id_master');

        // Return the view with the data
        return view('analisis_periode/index', $data);
    }

    public function new($id_master)
    {
        $data['id_master'] = $id_master;
        $data['state_type'] = $this->analisisPeriodeModel->getStateType();
        $data['active_type'] = $this->analisisPeriodeModel->getActiveOptions();
        return view('analisis_periode/new', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        // Save the data
        if ($this->analisisPeriodeModel->save($data)) {

            return redirect()->to('/admin/analisis_master/' . $data['id_master'] . '/analisis-periode')->with('message', 'Analisis added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->analisisPeriodeModel->errors());
        }
    }

    public function edit($id)
    {
        $data['state_type'] = $this->analisisPeriodeModel->getStateType();
        $data['active_type'] = $this->analisisPeriodeModel->getActiveOptions();
        $data['analisisPeriodeModel'] = $this->analisisPeriodeModel->find($id);
        if (!$data['analisisPeriodeModel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Analisis Periode not found');
        }
        return view('analisis_periode/edit', $data);
    }

    public function update($id)
    {
        // Validation
        if (!$this->validate([
            'nama'              => 'required|max_length[50]',
            'id_state'          => 'required|integer',
            'aktif'             => 'required|in_list[0,1]',
            'keterangan'        => 'max_length[100]',
            'tahun_pelaksanaan' => 'required|exact_length[4]',
        ])) {
            return redirect()->to('/analisis-periode/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update the data
        $this->analisisPeriodeModel->update($id, [
            'nama'              => $this->request->getVar('nama'),
            'id_state'          => $this->request->getVar('id_state'),
            'aktif'             => $this->request->getVar('aktif'),
            'keterangan'        => $this->request->getVar('keterangan'),
            'tahun_pelaksanaan' => $this->request->getVar('tahun_pelaksanaan'),
        ]);

        return redirect()->to('/analisis-periode')->with('message', 'Analisis Periode successfully updated');
    }

    public function delete($id)
    {
        // Retrieve the record to get the id_master
        $analisisPeriode = $this->analisisPeriodeModel->find($id);
        $id_master = $analisisPeriode['id_master'];

        // Delete the record from the database
        $this->analisisPeriodeModel->delete($id);

        // Redirect back to the index page
        return redirect()->to('/admin/analisis_master/' . $id_master . '/analisis-periode');
    }
}
