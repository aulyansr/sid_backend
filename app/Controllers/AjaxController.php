<?php

namespace App\Controllers;

use App\Models\DesaPamongModel;
use App\Models\ClusterDesaModel;
use App\Models\TwebPenduduk;
use App\Models\KeluargaModel;

class AjaxController extends BaseController
{
    public function searchPamong()
    {
        $keyword = $this->request->getGet('q');
        $model = new DesaPamongModel();


        $results = $model->like('pamong_nip', $keyword, 'both', true)
            ->orLike('pamong_nama', $keyword, 'both', true)
            ->findAll();

        return $this->response->setJSON($results);
    }

    public function searchPenduduk()
    {
        $keyword = $this->request->getGet('q');
        $model = new TwebPenduduk();


        // Perform the search with a limit on the number of results
        $results = $model->like('CAST(nik AS TEXT)', $keyword, 'both', true) // Cast nik to text for LIKE
            ->orLike('nama', $keyword, 'both', true)
            ->findAll();

        return $this->response->setJSON($results);
    }

    public function getRW($dusunId)
    {
        $model = new ClusterDesaModel();
        $rwList = $model->getRW($dusunId); // Use $model directly
        return $this->response->setJSON($rwList);
    }

    public function getRT($rwId)
    {
        $model = new ClusterDesaModel();
        $rtList = $model->getRT($rwId); // Use $model directly
        return $this->response->setJSON($rtList);
    }

    public function search_kk()
    {
        $searchTerm = $this->request->getGet('q');  // Get the search term from Select2 input
        $results = [];

        $model = new KeluargaModel();

        // Query to search for KK, NIK Kepala, and Nama
        $kkRecords = $model
            ->select('tweb_keluarga.no_kk, tweb_keluarga.nik_kepala, tweb_penduduk.nama')
            ->join('tweb_penduduk', 'tweb_penduduk.nik = tweb_keluarga.nik_kepala')
            ->groupStart()  // Start a group for OR conditions
            ->like('CAST(tweb_keluarga.no_kk AS TEXT)', $searchTerm)  // Cast no_kk to text
            ->orLike('CAST(tweb_keluarga.nik_kepala AS TEXT)', $searchTerm)
            ->orLike('tweb_penduduk.nama', $searchTerm)
            ->groupEnd()  // Close the group
            ->limit(10)  // Limit results to 10 for Select2 dropdown
            ->findAll();

        // Prepare the results for JSON response
        foreach ($kkRecords as $kk) {
            $results[] = [
                'id' => $kk['no_kk'],  // Set the id to no_kk
                'text' => $kk['no_kk'] . ' - ' . $kk['nik_kepala'] . ' - ' . $kk['nama']  // Display format
            ];
        }

        // Return the results as a JSON response
        return $this->response->setJSON($results);
    }
}
