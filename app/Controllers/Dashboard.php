<?php

namespace App\Controllers;

use App\Models\TwebPenduduk;
use App\Models\DesaModel;


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
        $desa                   = $desaModel->where('permalink', $permalink)->first();
        $data['total_penduduk'] = $this->pendudukModel->countAll();
        return view('dashboard/index', $data);
    }
}
