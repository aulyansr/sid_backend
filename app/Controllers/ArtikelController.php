<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Controller;

class ArtikelController extends Controller
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
        $data['activeTab'] = 'artikel';
        return view('artikel/index', $data);
    }

    public function new()
    {
        $data['kategoris'] = $this->kategori->findAll();
        return view('artikel/new', $data);
    }

    public function store()
    {

        $image = $this->request->getFile('gambar');
        $validation = \Config\Services::validation();
        $gambarpath = null;

        $validationRules = [
            'gambar' => [
                'rules' => 'uploaded[gambar]'
                    . '|is_image[gambar]'
                    . '|mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[gambar,1000]', // 1000 KB limit
                'errors' => [
                    'uploaded' => 'No image uploaded.',
                    'is_image' => 'The file must be an image.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp.',
                    'max_size' => 'The image size must be less than 1 MB.'
                ]
            ],
            'isi'          => 'required|string',
            'enabled'      => 'required|integer|max_length[1]',
            'tgl_upload'   => 'required|valid_date',
            'id_kategori'  => 'required|integer',
            'id_user'      => 'required|integer',
            'judul'        => 'required|string|max_length[100]',
            'headline'     => 'integer|max_length[1]',
            'gambar1'      => 'permit_empty|string|max_length[200]',
            'gambar2'      => 'permit_empty|string|max_length[200]',
            'gambar3'      => 'permit_empty|string|max_length[200]',
            'dokumen'      => 'permit_empty|string|max_length[400]',
            'link_dokumen' => 'permit_empty|string|max_length[200]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newName = $image->getRandomName();
        $image->move('uploads', $newName);
        $gambarpath = 'uploads/' . $newName;

        $data = [
            'gambar'       => $gambarpath,
            'isi'          => $this->request->getVar('isi'),
            'enabled'      => $this->request->getVar('enabled'),
            'tgl_upload'   => $this->request->getVar('tgl_upload'),
            'id_kategori'  => $this->request->getVar('id_kategori'),
            'id_user'      => $this->request->getVar('id_user'),
            'judul'        => $this->request->getVar('judul'),
            'headline'     => $this->request->getVar('headline'),
            'gambar1'      => $this->request->getVar('gambar1'),
            'gambar2'      => $this->request->getVar('gambar2'),
            'gambar3'      => $this->request->getVar('gambar3'),
            'dokumen'      => $this->request->getVar('dokumen'),
            'link_dokumen' => $this->request->getVar('link_dokumen'),
        ];

        if ($this->artikelModel->save($data)) {
            return redirect()->to('/admin/artikel')->with('message', 'Artikel added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }
    }

    public function edit($id)
    {
        $data['artikel'] = $this->artikelModel->find($id);
        $data['kategoris'] = $this->kategori->findAll();
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }
        return view('artikel/edit', $data);
    }

    public function update($id)
    {
        $image = $this->request->getFile('gambar');
        $validation = \Config\Services::validation();
        $gambarpath = null;

        if ($image && $image->isValid()) {
            $validation->setRules([
                'gambar' => [
                    'rules' => 'uploaded[gambar]'
                        . '|is_image[gambar]'
                        . '|mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[gambar,1000]'
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $newName = $image->getRandomName();
            $image->move('uploads', $newName);
            $gambarpath = 'uploads/' . $newName;
        }
        $validationRules = [
            'isi'          => 'required|string',
            'enabled'      => 'required|integer|max_length[1]',
            'tgl_upload'   => 'required|valid_date',
            'id_kategori'  => 'required|integer',
            'id_user'      => 'required|integer',
            'judul'        => 'required|string|max_length[100]',
            'headline'     => 'integer|max_length[1]',
            'gambar1'      => 'permit_empty|string|max_length[200]',
            'gambar2'      => 'permit_empty|string|max_length[200]',
            'gambar3'      => 'permit_empty|string|max_length[200]',
            'dokumen'      => 'permit_empty|string|max_length[400]',
            'link_dokumen' => 'permit_empty|string|max_length[200]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'           => $id,

            'isi'          => $this->request->getPost('isi'),
            'enabled'      => $this->request->getPost('enabled'),
            'tgl_upload'   => $this->request->getPost('tgl_upload'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_user'      => $this->request->getPost('id_user'),
            'judul'        => $this->request->getPost('judul'),
            'headline'     => $this->request->getPost('headline'),
            'gambar1'      => $this->request->getPost('gambar1'),
            'gambar2'      => $this->request->getPost('gambar2'),
            'gambar3'      => $this->request->getPost('gambar3'),
            'dokumen'      => $this->request->getPost('dokumen'),
            'link_dokumen' => $this->request->getPost('link_dokumen'),
        ];

        if ($gambarpath) {
            $data['gambar'] = $gambarpath;
        }

        $result = $this->artikelModel->update($id, $data);
        $message = $result ? 'Artikel updated successfully.' : 'Update failed';
        $redirect = $result ? '/admin/artikel' : 'back';

        return redirect()->to($redirect)->with('message', $message)->withInput();
    }

    public function delete($id)
    {
        if ($this->artikelModel->delete($id)) {
            return redirect()->to('/admin/artikel')->with('message', 'Artikel deleted successfully.');
        } else {
            return redirect()->to('/admin/artikel')->with('error', 'Failed to delete artikel.');
        }
    }
}
