<?php

namespace App\Controllers;

use App\Models\TwebPenduduk;
use App\Models\DesaModel;
use App\Models\AnalisisMasterModel;


class Dashboard extends BaseController
{
    protected $pendudukModel;

    public function __construct()
    {
        $this->pendudukModel = new TwebPenduduk();
    }

    public function index(string $permalink = null)
    {
        $desaModel              = new DesaModel();
        $analisis              = new AnalisisMasterModel();
        $currentUser = auth()->user();
        $desa                   = $desaModel->where('id', $currentUser->desa_id)->first();

        $data['total_penduduk'] = $this->pendudukModel->where('desa_id', $currentUser->desa_id)->countAllResults();
        $data['total_analisis'] = $analisis->where('desa_id', $currentUser->desa_id)->countAllResults();
        return view('dashboard/index', $data);
    }
}
