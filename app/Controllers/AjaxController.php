<?php

namespace App\Controllers;

use App\Models\DesaPamongModel;
use App\Models\ClusterDesaModel;
use App\Models\TwebPenduduk;

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
            ->limit(10) // Limit the search results to 10
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
}
