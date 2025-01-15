<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KeluargaModel;
use App\Models\TwebPenduduk;
use App\Models\ClusterDesaModel;
use App\Models\DesaModel;

class Keluarga extends BaseController
{
    protected $keluargaModel;
    protected $wilayahModel;
    protected $pendudukModel;
    protected $db;

    public function __construct()
    {
        // Initialize the model
        $this->keluargaModel = new KeluargaModel();
        $this->pendudukModel = new TwebPenduduk();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $currentUser = auth()->user();
        $data['activeTab'] = 'keluarga';
        if ($currentUser->inGroup('superadmin')) {
            $data['keluargas'] = $this->keluargaModel->getKepalaKeluarga();
        } else {
            $data['keluargas'] = $this->keluargaModel
                ->where('tweb_keluarga.desa_id', $currentUser->desa_id)
                ->getKepalaKeluarga();
        }



        return view('keluarga/index', $data);
    }

    public function new()
    {
        $desaModel   = new DesaModel();
        $hubunganList = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();
        $data = [
            'hubunganList' => $hubunganList,
            'list_desa'    => $desaModel->findAll()
        ];

        return view('keluarga/new', $data);
    }

    public function create()
    {
        $postData = $this->request->getPost();

        // Start a database transaction to ensure atomicity
        $this->db->transBegin();

        try {
            $postData['tgl_daftar'] = date('Y-m-d H:i:s');
            // Save the main keluarga data (like nomor KK, nik_kepala, etc.)
            if (!$this->keluargaModel->save($postData)) {
                // If validation fails, get the validation errors

                $errors = $this->keluargaModel->errors();
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $errors);
            }

            // Get the newly created keluarga ID
            $keluargaId = $this->keluargaModel->insertID();

            // Now, process and save each family member (anggota keluarga)
            if (isset($postData['anggota_keluarga'])) {
                foreach ($postData['anggota_keluarga'] as $anggota) {
                    // Find the penduduk (anggota) by NIK
                    $existingPenduduk = $this->pendudukModel->where('nik', $anggota['nik'])->first();

                    // Check if the penduduk exists
                    if ($existingPenduduk) {
                        // Prepare anggota data for update
                        $anggotaData = [
                            'id_kk' => $keluargaId, // Assign keluarga ID (foreign key)
                            'kk_level' => $anggota['kk_level'], // Hubungan dalam keluarga
                            // Add any other fields you want to update for penduduk here
                        ];

                        // Update penduduk with new data
                        if (!$this->pendudukModel->update($existingPenduduk['id'], $anggotaData)) {
                            // If saving anggota fails, rollback transaction and return errors
                            $errors = $this->pendudukModel->errors();
                            return redirect()->back()
                                ->withInput()
                                ->with('errors', $errors);
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
            return redirect()->to('/admin/keluarga')->with('success', 'Data has been saved successfully.');
        } catch (\Exception $e) {
            // In case of exception, rollback transaction
            $this->db->transRollback();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Fetch keluarga based on the provided ID
        $keluarga = $this->keluargaModel->find($id);

        if (!$keluarga) {
            return redirect()->back()->with('error', 'Keluarga not found');
        }

        // Fetch the head of the family (kepala keluarga)
        $kepalaKeluarga = $this->pendudukModel
            ->select('nik, nama')
            ->where('nik', $keluarga['nik_kepala'])
            ->first();

        // Fetch anggota_keluarga related to this keluarga by matching no_kk
        $anggotaKeluarga = $this->pendudukModel->getAllAttributes()
            ->where('id_kk', $keluarga['id'])
            ->findAll();

        // Pass data to the view
        $data = [
            'keluarga' => $keluarga,
            'kepalaKeluarga' => $kepalaKeluarga,
            'anggota_keluarga' => $anggotaKeluarga
        ];

        return view('keluarga/show', $data);
    }



    public function edit($id)
    {
        // Fetch the specific keluarga record
        $keluarga = $this->keluargaModel->find($id);
        $kepala_keluarga  = $this->pendudukModel->where('nik', $keluarga['nik_kepala'])->first();

        if (!$keluarga) {
            // Handle case where keluarga doesn't exist
            return redirect()->back()->with('error', 'Keluarga not found');
        }

        // Fetch anggota_keluarga related to this keluarga by matching no_kk
        $anggotaKeluarga = $this->pendudukModel
            ->where('id_kk', $keluarga['id'])
            ->findAll(); // Find all matching penduduk records for this no_kk

        // Fetch list of possible hubungan dalam keluarga
        $hubunganList = $this->db->table('tweb_penduduk_hubungan')->get()->getResultArray();

        // Merge data into a single array
        $data = [
            'keluarga' => $keluarga,
            'kepala_keluarga' => $kepala_keluarga,
            'anggota_keluarga' => $anggotaKeluarga,
            'hubunganList' => $hubunganList,
        ];

        // Prepare and return data for the view
        return view('keluarga/edit', $data);
    }


    public function update($id)
    {
        $postData = $this->request->getPost();

        // Start database transaction
        $this->db->transBegin();

        // Reset anggota keluarga sebelumnya
        $existingAnggota = $this->pendudukModel->where('id_kk', $id)->findAll();
        if (!empty($existingAnggota)) {
            foreach ($existingAnggota as $penduduk) {
                $this->pendudukModel->update($penduduk['id'], ['id_kk' => null]);
            }
        }

        if (isset($postData['anggota_keluarga'])) {
            foreach ($postData['anggota_keluarga'] as $anggota) {
                // Find the penduduk (anggota) by NIK
                $existingPenduduk = $this->pendudukModel->where('nik', $anggota['nik'])->first();

                // Check if the penduduk exists
                if ($existingPenduduk) {
                    // Prepare anggota data for update
                    $anggotaData = [
                        'id_kk' => $id, // Assign keluarga ID (foreign key)
                        'kk_level' => $anggota['kk_level'], // Hubungan dalam keluarga
                        // Add any other fields you want to update for penduduk here
                    ];

                    // Update penduduk with new data
                    if (!$this->pendudukModel->update($existingPenduduk['id'], $anggotaData)) {
                        // If saving anggota fails, rollback transaction and return errors
                        $errors = $this->pendudukModel->errors();
                        return redirect()->back()
                            ->withInput()
                            ->with('errors', $errors);
                    }
                } else {
                    // If penduduk is not found, handle error (optional)
                    return redirect()->back()
                        ->withInput()
                        ->with('errors', 'Penduduk dengan NIK ' . $anggota['nik'] . ' tidak ditemukan.');
                }
            }
        }
        // Commit the transaction
        $this->db->transCommit();
        return redirect()->to(base_url('admin/keluarga'))->with('message', 'Data keluarga berhasil diperbarui.');
    }


    public function delete($id)
    {
        $this->keluargaModel->delete($id);
        return redirect()->to('/admin/keluarga');
    }
}
