<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\GambarGalleryModel;
use App\Models\KomentarModel;
use App\Models\TwebPenduduk;
use App\Models\DesaModel;

class Page extends BaseController
{
    protected $artikelModel;
    protected $komentarModel;
    protected $kategori;
    protected $gallery;
    protected $pendudukModel;
    protected $desaModel;
    public function __construct()
    {
        $this->artikelModel  = new ArtikelModel();
        $this->kategori      = new KategoriModel();
        $this->gallery       = new GambarGalleryModel();
        $this->komentarModel = new KomentarModel();
        $this->pendudukModel = new TwebPenduduk();
        $this->desaModel = new DesaModel();
    }

    public function index()

    {
        $session = session();
        $session->remove('desa_permalink');
        $data['villages'] = $this->desaModel->orderBy('id')->findAll();

        return view('pages/select_desa', $data);
    }

    public function desa($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();

        if (!$village) {
            // Handle the case where no village is found (e.g., show 404 page)
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Village not found.");
        }
        $data['artikels'] = $this->artikelModel->where('desa_id', $village['id'])->orderBy('id', 'DESC')->limit(5)->findAll();

        $data['headline'] = $this->artikelModel->where('artikel.enabled', 1)->where('artikel.desa_id', $village['id'])->where('headline', 1)->getArtikels();
        $data['gallery'] = $this->gallery->where('gambar_gallery.desa_id', $village['id'])->where('tipe', 0)->findAll(1);
        $data['categories'] = $this->kategori->findAll();
        $data['comments'] = $this->komentarModel->getcomments(5, $village['id']);
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

    public function statistik_pendidikan_kk($segment)

    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['pendidikanSummary'] = $this->pendudukModel->where('desa_id', $village['id'])->getPendidikanSummary();

        return view('pages/statistik_pendidikan_kk', $data);
    }
    public function statistik_pendidikan_tempuh($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['pendidikanSummary'] = $this->pendudukModel->where('desa_id', $village['id'])->getPendidikanSummary();

        return view('pages/statistik_pendidikan_tempuh', $data);
    }

    public function statistik_pekerjaan($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['summary'] = $this->pendudukModel->where('desa_id', $village['id'])->getPekerjaan();

        return view('pages/statistik_pekerjaan', $data);
    }

    public function statistik_kelompok_umur($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['summary'] = $this->pendudukModel->where('desa_id', $village['id'])->getKelompokUmur();

        return view('pages/statistik_kelompok_umur', $data);
    }

    public function statistik_jenis_kelamin($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['summary'] = $this->pendudukModel->where('desa_id', $village['id'])->getJenkel();

        return view('pages/statistik_jenis_kelamin', $data);
    }

    public function statistik_agama($segment)
    {
        $village = $this->desaModel->where('permalink', $segment)->first();
        $data['summary'] = $this->pendudukModel->where('desa_id', $village['id'])->getAgama();

        return view('pages/statistik_agama', $data);
    }

    public function page_category($segment, $id)
    {
        $data['category'] = $this->kategori->find($id);
        $village = $this->desaModel->where('permalink', $segment)->first();

        if (!$village) {
            // Handle the case where no village is found (e.g., show 404 page)
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Village not found.");
        }
        $data['articles'] = $this->artikelModel->where('desa_id', $village['id'])->where('enabled', 1)->where('id_kategori', $id)->orderBy('id', 'DESC')->findAll();
        return view('pages/artikel_category', $data);
    }

    public function privasi()
    {
        return view('pages/privasi',);
    }
    public function ketentuan()
    {
        return view('pages/ketentuan',);
    }
    public function about()
    {
        return view('pages/about',);
    }
}
