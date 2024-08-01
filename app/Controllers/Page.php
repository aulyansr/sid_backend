<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\GambarGalleryModel;

class Page extends BaseController
{
    protected $artikelModel;
    protected $kategori;
    protected $gallery;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategori = new KategoriModel();
        $this->gallery = new GambarGalleryModel();
    }

    public function index()
    {
        $data['artikels'] = $this->artikelModel->limit(5)->findAll();
        $data['headline'] = $this->artikelModel->where('headline', 1)->findAll();
        $data['gallery'] = $this->gallery->where('tipe', 0)->findAll(1);
        $data['categories'] = $this->kategori->findAll();
        return view('pages/index', $data);
    }

    public function articles()
    {
        $data['articles'] = $this->artikelModel->findAll();
        return view('pages/articles', $data);
    }

    public function categories()
    {
        $data['categories'] = $this->kategori->findAll();
        return view('pages/categories', $data);
    }

    public function galleries()
    {
        $perPage = 6;
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;

        $data['galleries'] = $this->gallery
            ->where('tipe', 0)
            ->paginate($perPage, 'galleries');

        $data['pager'] = $this->gallery->pager;
        $data['currentPage'] = $page;

        return view('pages/galleries', $data);
    }
}
