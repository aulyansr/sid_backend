<?php

namespace App\Controllers;

use App\Models\TwebPenduduk;


class Dashboard extends BaseController
{
    protected $pendudukModel;

    public function __construct()
    {
        $this->pendudukModel = new TwebPenduduk();
    }

    public function index(): string
    {
        $data['total_penduduk'] = $this->pendudukModel->countAll();
        return view('dashboard/index', $data);
    }
}
