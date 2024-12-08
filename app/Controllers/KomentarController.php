<?php

namespace App\Controllers;

use App\Models\KomentarModel;
use CodeIgniter\Controller;

class KomentarController extends Controller
{
    protected $komentarModel;

    public function __construct()
    {
        $this->komentarModel = new KomentarModel();
    }

    public function index()
    {
        $data['komentars'] = $this->komentarModel->findAll();
        $data['activeTab'] = 'komentar';
        return view('komentar/index', $data);
    }

    public function create()
    {
        return view('komentar/create');
    }

    public function store()
    {
        $data = [
            'id_artikel' => $this->request->getPost('id_artikel'),
            'owner' => $this->request->getPost('owner'),
            'email' => $this->request->getPost('email'),
            'komentar' => $this->request->getPost('komentar'),
            'tgl_upload' => date('Y-m-d H:i:s'),
            'enabled' => 1,
        ];

        // Save the new comment
        $this->komentarModel->save($data);

        // Redirect back to the article page
        return redirect()->back();
    }

    public function disable($id)
    {
        $this->komentarModel->update($id, ['enabled' => 0]);
        return redirect()->to('/admin/komentar');
    }

    public function delete($id)
    {
        if ($this->komentarModel->delete($id)) {
            return redirect()->to('/admin/komentar')->with('message', 'komentar deleted successfully.');
        } else {
            return redirect()->to('/admin/komentar')->with('error', 'Failed to delete komentar.');
        }
    }
}
