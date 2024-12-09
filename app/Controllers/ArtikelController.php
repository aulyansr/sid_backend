<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\KomentarModel;
use App\Models\UserModel;
use App\Models\DesaModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class ArtikelController extends BaseController
{
    protected $artikelModel;
    protected $kategori;
    protected $komentar;
    protected $user;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategori = new KategoriModel();
        $this->user = new UserModel();
        $this->komentar = new KomentarModel();
    }

    public function index()
    {
        if (auth()->user()->inGroup('superadmin')) {
            $data['artikels'] = $this->artikelModel->getArtikels();
        } else {
            $data['artikels'] = $this->artikelModel
                ->where('artikel.desa_id', auth()->user()->desa_id)
                ->getArtikels();
        }
        $data['activeTab'] = 'artikel';
        return view('artikel/index', $data);
    }

    public function new()
    {
        $desaModel   = new DesaModel();
        $data['kategoris'] = $this->kategori->findAll();
        $data['list_desa'] =  $desaModel->findAll();
        return view('artikel/new', $data);
    }

    public function store()
    {

        $image = $this->request->getFile('gambar');

        $validation = \Config\Services::validation();

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
            'gambar1' => [
                'rules' => 'permit_empty|uploaded[gambar1]|is_image[gambar1]|mime_in[gambar1,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar1,1000]',
                'errors' => [
                    'uploaded' => 'No image uploaded for gambar1.',
                    'is_image' => 'The file must be an image for gambar1.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar1.',
                    'max_size' => 'The image size must be less than 1 MB for gambar1.'
                ]
            ],
            'gambar2' => [
                'rules' => 'permit_empty|uploaded[gambar2]|is_image[gambar2]|mime_in[gambar2,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar2,1000]',
                'errors' => [
                    'uploaded' => 'No image uploaded for gambar2.',
                    'is_image' => 'The file must be an image for gambar2.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar2.',
                    'max_size' => 'The image size must be less than 1 MB for gambar2.'
                ]
            ],
            'gambar3' => [
                'rules' => 'permit_empty|uploaded[gambar3]|is_image[gambar3]|mime_in[gambar3,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar3,1000]',
                'errors' => [
                    'uploaded' => 'No image uploaded for gambar3.',
                    'is_image' => 'The file must be an image for gambar3.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar3.',
                    'max_size' => 'The image size must be less than 1 MB for gambar3.'
                ]
            ],
            'isi'          => 'required|string',
            'enabled'      => 'required|integer|max_length[1]',
            'tgl_upload'   => 'required|valid_date',
            'id_kategori'  => 'required|integer',
            'id_user'      => 'required|integer',
            'judul'        => 'required|string|max_length[100]',
            'link_dokumen' => 'permit_empty|string|max_length[200]',

        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $random_id =  (new \DateTime())->format('YmdHis');
        $uploadPath = 'uploads/artikel/' . $random_id;

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move the main image
        $newName = $image->getFilename();
        $image->move($uploadPath, $newName);
        $gambarpath = $uploadPath . '/' . $newName;

        $imageService = \Config\Services::image()
            ->withFile($gambarpath)
            ->fit(160, 160) // Crop the image to 160x160
            ->save($uploadPath . '/thumb_' . $newName);



        $additionalImages = ['gambar1', 'gambar2', 'gambar3'];
        $additionalImagePaths = [];

        foreach ($additionalImages as $key) {
            $additionalImage = $this->request->getFile($key);
            if ($additionalImage && $additionalImage->isValid()) {
                $newName = $additionalImage->getRandomName();
                $additionalImage->move($uploadPath, $newName);
                $additionalImagePaths[$key] = $uploadPath . '/' . $newName;
            } else {
                $additionalImagePaths[$key] = null;
            }
        }

        $data = [
            'gambar'       => $gambarpath,
            'isi'          => $this->request->getVar('isi'),
            'enabled'      => $this->request->getVar('enabled'),
            'tgl_upload'   => $this->request->getVar('tgl_upload'),
            'id_kategori'  => $this->request->getVar('id_kategori'),
            'id_user'      => $this->request->getVar('id_user'),
            'judul'        => $this->request->getVar('judul'),
            'headline'     => $this->request->getVar('headline') ? 1 : 0,
            'gambar1'      => $additionalImagePaths['gambar1'],
            'gambar2'      => $additionalImagePaths['gambar2'],
            'gambar3'      => $additionalImagePaths['gambar3'],
            'dokumen'      => $this->request->getVar('dokumen'),
            'link_dokumen' => $this->request->getVar('link_dokumen'),
            'desa_id' => $this->request->getPost('desa_id'),
        ];

        if ($this->artikelModel->save($data)) {

            return redirect()->to('/admin/artikel')->with('message', 'Artikel added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }
    }

    public function show($id)
    {
        $data['artikel'] = $this->artikelModel->find($id);
        $data['user'] =  $this->user->find($data['artikel']['id_user']);
        $data['kategori'] =  $this->kategori->find($data['artikel']['id_kategori']);
        $data['comments'] = $this->komentar
            ->where('id_artikel', $id)
            ->where('enabled', 1)
            ->findAll();

        if (isset($data['artikel']['tgl_upload'])) {
            $data['artikel']['tgl_upload'] = Time::parse($data['artikel']['tgl_upload']);
        }
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }
        return view('artikel/show', $data);
    }

    public function edit($id)
    {
        $data['artikel']   = $this->artikelModel->find($id);
        $desaModel         = new DesaModel();
        $data['kategoris'] = $this->kategori->findAll();
        $data['list_desa'] = $desaModel->findAll();
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }
        return view('artikel/edit', $data);
    }

    public function update($id)
    {
        $image = $this->request->getFile('gambar');
        $validation = \Config\Services::validation();

        $validationRules = [
            'gambar' => [
                'rules' => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar,1000]',
                'errors' => [
                    'is_image' => 'The file must be an image.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp.',
                    'max_size' => 'The image size must be less than 1 MB.'
                ]
            ],
            'gambar1' => [
                'rules' => 'permit_empty|is_image[gambar1]|mime_in[gambar1,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar1,1000]',
                'errors' => [
                    'is_image' => 'The file must be an image for gambar1.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar1.',
                    'max_size' => 'The image size must be less than 1 MB for gambar1.'
                ]
            ],
            'gambar2' => [
                'rules' => 'permit_empty|is_image[gambar2]|mime_in[gambar2,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar2,1000]',
                'errors' => [
                    'is_image' => 'The file must be an image for gambar2.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar2.',
                    'max_size' => 'The image size must be less than 1 MB for gambar2.'
                ]
            ],
            'gambar3' => [
                'rules' => 'permit_empty|is_image[gambar3]|mime_in[gambar3,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[gambar3,1000]',
                'errors' => [
                    'is_image' => 'The file must be an image for gambar3.',
                    'mime_in' => 'The file type must be jpg, jpeg, gif, png, or webp for gambar3.',
                    'max_size' => 'The image size must be less than 1 MB for gambar3.'
                ]
            ],
            'isi'          => 'required|string',
            'enabled'      => 'required|integer|max_length[1]',
            'tgl_upload'   => 'required|valid_date',
            'id_kategori'  => 'required|integer',
            'id_user'      => 'required|integer',
            'judul'        => 'required|string|max_length[100]',
            'link_dokumen' => 'permit_empty|string|max_length[200]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Fetch existing article data
        $artikel = $this->artikelModel->find($id);

        if (!$artikel) {
            return redirect()->back()->with('error', 'Artikel not found.');
        }

        $uploadPath = 'uploads/artikel/' . $id;

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $gambarpath = $artikel['gambar']; // Default to existing image path
        if ($image && $image->isValid()) {
            $newName = $image->getRandomName();
            $image->move($uploadPath, $newName);
            $gambarpath = $uploadPath . '/' . $newName;

            // Generate thumbnail
            $imageService = \Config\Services::image()
                ->withFile($gambarpath)
                ->fit(160, 160)
                ->save($uploadPath . '/thumb_' . $newName);
        }

        $additionalImages = ['gambar1', 'gambar2', 'gambar3'];
        $additionalImagePaths = [];

        foreach ($additionalImages as $key) {
            $additionalImage = $this->request->getFile($key);
            if ($additionalImage && $additionalImage->isValid()) {
                $newName = $additionalImage->getRandomName();
                $additionalImage->move($uploadPath, $newName);
                $additionalImagePaths[$key] = $uploadPath . '/' . $newName;
            } else {
                $additionalImagePaths[$key] = $artikel[$key] ?? null; // Retain existing path if no new upload
            }
        }

        $data = [
            'gambar'       => $gambarpath,
            'isi'          => $this->request->getPost('isi'),
            'enabled'      => $this->request->getPost('enabled'),
            'tgl_upload'   => $this->request->getPost('tgl_upload'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_user'      => $this->request->getPost('id_user'),
            'judul'        => $this->request->getPost('judul'),
            'headline'     => $this->request->getPost('headline') ? 1 : 0,
            'gambar1'      => $additionalImagePaths['gambar1'],
            'gambar2'      => $additionalImagePaths['gambar2'],
            'gambar3'      => $additionalImagePaths['gambar3'],
            'dokumen'      => $this->request->getPost('dokumen'),
            'link_dokumen' => $this->request->getPost('link_dokumen'),
            'desa_id' => $this->request->getPost('desa_id'),
        ];

        if ($this->artikelModel->update($id, $data)) {
            return redirect()->to('/admin/artikel')->with('message', 'Artikel updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }
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
