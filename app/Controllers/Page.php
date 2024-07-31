<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use \Tatter\Relations\Traits\ModelTrait;

class Page extends BaseController
{
    protected $artikelModel;
    protected $kategori;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data['artikels'] = $this->artikelModel->getArtikels();
        $kategoriModel = new KategoriModel();
        $data['categories'] = $kategoriModel->findAll();
        return view('pages/index', $data);
    }
}
