<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RtmModel;
use App\Models\TwebPenduduk;
use App\Models\KeluargaModel;
use CodeIgniter\Database\BaseBuilder;

class Rtm extends BaseController
{
    protected $rtmModel;
    protected $keluargaModel;
    protected $pendudukModel;
    protected $db;

    public function __construct()
    {
        // Initialize the model
        $this->rtmModel = new RtmModel();
        $this->keluargaModel = new KeluargaModel();
        $this->pendudukModel = new TwebPenduduk();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['activeTab'] = 'rtm';
        $data['rtms'] = $this->rtmModel->getKepalaRtm();

        return view('rtm/index', $data);
    }

    public function new()
    {


        return view('rtm/new');
    }

    public function create()
    {
        // Get the posted data from the request
        $postData = $this->request->getPost();

        // Start a database transaction to ensure atomicity
        $this->db->transBegin();

        try {
            // Add the registration date
            $postData['tgl_daftar'] = date('Y-m-d H:i:s');

            // Check if the NIK Kepala is provided
            if (empty($postData['nik_kepala'])) {
                return redirect()->back()->withInput()->with('error', 'NIK Kepala Keluarga tidak boleh kosong.');
            }



            // Prepare the data for the new RTM record
            $rtmData = [
                'no_kk'        => 0,
                'nik_kepala'   => $postData['nik_kepala'],
                'nama_kepala'  => $postData['nama_kepala'],
                'jumlah_anggota' => isset($postData['anggota_keluarga']) ? count($postData['anggota_keluarga']) : 1,
                'status_rtm'   => 0,
                'tgl_daftar'   => date('Y-m-d H:i:s'),
            ];

            // Insert the new RTM record
            $rtmId = $this->rtmModel->insert($rtmData);

            if (!$rtmId) {
                return redirect()->back()->with('error', 'Gagal membuat RTM baru.');
            }

            // Now, process and update each family member (anggota keluarga)
            if (isset($postData['anggota_keluarga'])) {
                foreach ($postData['anggota_keluarga'] as $anggota) {
                    // Find the penduduk (anggota) by NIK
                    $existingPenduduk = $this->pendudukModel->where('nik', $anggota['nik'])->first();

                    // Check if the penduduk exists
                    if ($existingPenduduk) {
                        // Prepare anggota data for update
                        $anggotaData = [
                            'id_rtm' => $rtmId, // Update the id_rtm field
                        ];

                        // Update penduduk with new data
                        if (!$this->pendudukModel->update($existingPenduduk['id'], $anggotaData)) {
                            // If saving anggota fails, rollback transaction and return errors
                            $errors = $this->pendudukModel->errors();
                            return redirect()->back()->withInput()->with('errors', $errors);
                        }
                    } else {
                        // If penduduk is not found, handle error (optional)
                        return redirect()->back()
                            ->withInput()
                            ->with('errors', 'Penduduk dengan NIK ' . $anggota['nik'] . ' tidak ditemukan.');
                    }
                }
            }

            // If everything is successful, commit the transaction
            if ($this->db->transStatus() === false) {
                // Rollback if there was any issue
                $this->db->transRollback();
                return redirect()->back()->with('error', 'Failed to save keluarga and anggota.');
            }

            // Commit transaction
            $this->db->transCommit();

            // Redirect to keluarga list with a success message
            return redirect()->to('/admin/rumah-tangga')->with('success', 'Data has been saved successfully.');
        } catch (\Exception $e) {
            // In case of exception, rollback transaction
            $this->db->transRollback();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function create_rtm_kk()
    {
        // Get the No KK from the form input
        $no_kk = $this->request->getPost('no_kk');

        // Find keluarga data based on No KK
        $keluarga = $this->keluargaModel->where('no_kk', $no_kk)->first();

        if (!$keluarga) {
            // Redirect back with an error if No KK is not found
            return redirect()->back()->with('error', 'No KK tidak ditemukan.');
        }

        // Get nik_kepala from keluarga data
        $nik_kepala = $keluarga['nik_kepala'];

        // Find the nama_kepala from penduduk using nik_kepala
        $kepalaPenduduk = $this->pendudukModel->where('nik', $nik_kepala)->first();

        if (!$kepalaPenduduk) {
            // Redirect back with an error if nama kepala is not found
            return redirect()->back()->with('error', 'Nama kepala tidak ditemukan.');
        }

        // Count the number of members with the same no_kk
        $jumlahAnggota = $this->pendudukModel->where('id_kk', $keluarga['id'])->countAllResults();

        // Insert new RTM record
        $newRtmData = [
            'no_kk'        => $no_kk,
            'nik_kepala'   => $nik_kepala,
            'nama_kepala'  => $kepalaPenduduk['nama'],  // Get nama from penduduk
            'jumlah_anggota' => $jumlahAnggota, // Set the jumlah_anggota here
            'tgl_daftar'   => date('Y-m-d H:i:s'),  // Add the registration date here
        ];


        $rtmId = $this->rtmModel->insert($newRtmData);

        if (!$rtmId) {
            return redirect()->back()->with('error', 'Gagal membuat RTM baru.');
        }

        // Update penduduk with the new RTM ID
        $this->pendudukModel->where('id_kk', $keluarga['id'])
            ->set('id_rtm', $rtmId)
            ->update();

        // Redirect to the RTM list with a success message
        return redirect()->to('/admin/rumah-tangga')->with('message', 'RTM berhasil dibuat berdasarkan No KK.');
    }


    public function show($id)
    {
        // Fetch RTM based on the provided ID
        $rtm = $this->rtmModel->find($id);

        if (!$rtm) {
            return redirect()->back()->with('error', 'RTM not found');
        }

        // Fetch the head of the family (kepala RTM)
        $kepalaRtm = $this->pendudukModel
            ->select('nik, nama')
            ->where('nik', $rtm['nik_kepala'])
            ->first();

        $anggotaKeluarga = $this->pendudukModel->getAllAttributes()
            ->where('id_rtm', $rtm['id'])
            ->findAll();


        // Pass data to the view
        $data = [
            'rtm' => $rtm,
            'kepalaRtm' => $kepalaRtm,
            'anggota_keluarga' => $anggotaKeluarga
        ];

        return view('rtm/show', $data);
    }

    public function edit($id)
    {
        // Fetch the specific RTM record
        $rtm = $this->rtmModel->find($id);
        $kepalaRtm = $this->pendudukModel->where('nik', $rtm['nik_kepala'])->first();

        if (!$rtm) {
            // Handle case where RTM doesn't exist
            return redirect()->back()->with('error', 'RTM not found');
        }

        $anggotaKeluarga = $this->pendudukModel
            ->where('id_rtm', $rtm['id'])
            ->findAll(); // Find all matching penduduk records for this no_kk

        // Merge data into a single array
        $data = [
            'rtm' => $rtm,
            'kepalaRtm' => $kepalaRtm,
            'anggota_keluarga' => $anggotaKeluarga,
        ];

        // Prepare and return data for the view
        return view('rtm/edit', $data);
    }

    public function update($id)
    {
        $postData = $this->request->getPost();

        // Start database transaction
        $this->db->transBegin();

        // Update RTM data
        $rtmData = [
            'nik_kepala' => $postData['nik_kepala'],
        ];

        // Update RTM and handle errors
        if (!$this->rtmModel->update($id, $rtmData)) {
            // Rollback transaction and return errors if update fails
            $this->db->transRollback();
            $errors = $this->rtmModel->errors();
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Detach existing anggota_keluarga by setting their id_rtm to null
        $this->pendudukModel->where('id_rtm', $id)->set(['id_rtm' => NULL])->update();

        // Handle anggota_keluarga (family members) if provided
        if (isset($postData['anggota_keluarga'])) {
            foreach ($postData['anggota_keluarga'] as $anggota) {
                // Find the penduduk (anggota) by NIK
                $existingPenduduk = $this->pendudukModel->where('nik', $anggota['nik'])->first();

                // Check if the penduduk exists
                if ($existingPenduduk) {
                    // Prepare anggota data for update
                    $anggotaData = [
                        'id_rtm' => $id, // Re-assign the current RTM ID
                    ];

                    // Update penduduk with new data
                    if (!$this->pendudukModel->update($existingPenduduk['id'], $anggotaData)) {
                        // If saving anggota fails, rollback transaction and return errors
                        $this->db->transRollback();
                        $errors = $this->pendudukModel->errors();
                        return redirect()->back()->withInput()->with('errors', $errors);
                    }
                } else {
                    // If penduduk is not found, rollback and return an error
                    $this->db->transRollback();
                    return redirect()->back()
                        ->withInput()
                        ->with('errors', 'Penduduk dengan NIK ' . $anggota['nik'] . ' tidak ditemukan.');
                }
            }
        }

        // If everything is okay, commit the transaction
        $this->db->transCommit();

        // Redirect to the RTM list page with success message
        return redirect()->to(base_url('admin/rumah-tangga'))->with('message', 'Data RTM berhasil diperbarui.');
    }



    public function delete($id)
    {
        $this->rtmModel->delete($id);
        return redirect()->to('/admin/rumah-tangga');
    }
}
