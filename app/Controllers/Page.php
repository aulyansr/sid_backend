<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\GambarGalleryModel;
use App\Models\KomentarModel;

class Page extends BaseController
{
    protected $artikelModel;
    protected $komentarModel;
    protected $kategori;
    protected $gallery;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategori = new KategoriModel();
        $this->gallery = new GambarGalleryModel();
        $this->komentarModel = new KomentarModel();
    }

    public function index()
    {
        $data['artikels'] = $this->artikelModel->limit(5)->getArtikels();
        $data['headline'] = $this->artikelModel->where('headline', 1)->getArtikels();
        $data['gallery'] = $this->gallery->where('tipe', 0)->findAll(1);
        $data['categories'] = $this->kategori->findAll();
        $data['comments'] = $this->komentarModel

            ->where('enabled', 1)
            ->limit(5)
            ->findAll();
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

    public function search()
    {
        $pager = \Config\Services::pager();

        $query = $this->request->getGet('query');
        $perPage = 10; // Number of articles per page
        $page = $this->request->getGet('page') ? (int)$this->request->getGet('page') : 1;

        // Fetch paginated articles with search in title and content
        $data['articles'] = $this->artikelModel
            ->groupStart()
            ->like('judul', $query)
            ->orLike('isi', $query)
            ->groupEnd()
            ->paginate($perPage, 'search', $page);

        $data['pager'] = $this->artikelModel->pager;
        $data['currentPage'] = $page;
        $data['query'] = $query;

        return view('pages/search_results', $data);
    }
}
