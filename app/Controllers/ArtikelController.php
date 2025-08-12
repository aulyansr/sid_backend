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

        $image = service('request')->getFile('gambar');

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
            $additionalImage = service('request')->getFile($key);
            if ($additionalImage && $additionalImage->isValid()) {
                $newName = $additionalImage->getRandomName();
                $additionalImage->move($uploadPath, $newName);
                $additionalImagePaths[$key] = $uploadPath . '/' . $newName;
            } else {
                $additionalImagePaths[$key] = null;
            }
        }

        $currentUser = auth()->user();
        $data = [
            'gambar'       => $gambarpath,
            'isi'          => service('request')->getVar('isi'),
            'enabled'      => service('request')->getVar('enabled'),
            'tgl_upload'   => service('request')->getVar('tgl_upload'),
            'id_kategori'  => service('request')->getVar('id_kategori'),
            'id_user'      => service('request')->getVar('id_user'),
            'judul'        => service('request')->getVar('judul'),
            'headline'     => service('request')->getVar('headline') ? 1 : 0,
            'gambar1'      => $additionalImagePaths['gambar1'],
            'gambar2'      => $additionalImagePaths['gambar2'],
            'gambar3'      => $additionalImagePaths['gambar3'],
            'dokumen'      => service('request')->getVar('dokumen'),
            'link_dokumen' => service('request')->getVar('link_dokumen'),
            'desa_id' => service('request')->getPost('desa_id'),
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
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }

        // Only check desa_id if user is logged in and not superadmin
        $currentUser = auth()->user();
        if ($currentUser && !$currentUser->inGroup('superadmin') && (int) $data['artikel']['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }

        $data['user'] =  $this->user->find($data['artikel']['id_user']);
        $data['kategori'] =  $this->kategori->find($data['artikel']['id_kategori']);
        $data['comments'] = $this->komentar
            ->where('id_artikel', $id)
            ->where('enabled', 1)
            ->findAll();

        if (isset($data['artikel']['tgl_upload'])) {
            $data['artikel']['tgl_upload'] = Time::parse($data['artikel']['tgl_upload']);
        }
        return view('artikel/show', $data);
    }

    public function edit($id)
    {
        $data['artikel']   = $this->artikelModel->find($id);
        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }
        $currentUser = auth()->user();
        if (!$currentUser->inGroup('superadmin') && (int) $data['artikel']['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }
        $desaModel         = new DesaModel();
        $data['kategoris'] = $this->kategori->findAll();
        $data['list_desa'] = $desaModel->findAll();
        return view('artikel/edit', $data);
    }

    public function update($id)
    {
        $image = service('request')->getFile('gambar');
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
        $currentUser = auth()->user();
        if (!$currentUser->inGroup('superadmin') && (int) $artikel['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
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
            $additionalImage = service('request')->getFile($key);
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
            'isi'          => service('request')->getPost('isi'),
            'enabled'      => service('request')->getPost('enabled'),
            'tgl_upload'   => service('request')->getPost('tgl_upload'),
            'id_kategori'  => service('request')->getPost('id_kategori'),
            'id_user'      => service('request')->getPost('id_user'),
            'judul'        => service('request')->getPost('judul'),
            'headline'     => service('request')->getPost('headline') ? 1 : 0,
            'gambar1'      => $additionalImagePaths['gambar1'],
            'gambar2'      => $additionalImagePaths['gambar2'],
            'gambar3'      => $additionalImagePaths['gambar3'],
            'dokumen'      => service('request')->getPost('dokumen'),
            'link_dokumen' => service('request')->getPost('link_dokumen'),
            'desa_id' => $currentUser->inGroup('superadmin') ? service('request')->getPost('desa_id') : ($currentUser->desa_id ?? null),
        ];

        if ($this->artikelModel->update($id, $data)) {
            return redirect()->to('/admin/artikel')->with('message', 'Artikel updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->artikelModel->errors());
        }
    }


    public function delete($id)
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel not found.');
        }
        $currentUser = auth()->user();
        if (!$currentUser->inGroup('superadmin') && (int) $artikel['desa_id'] !== (int) ($currentUser->desa_id ?? 0)) {
            return redirect()->to('/admin/artikel')->with('error', 'Akses ditolak.');
        }
        if ($this->artikelModel->delete($id)) {
            return redirect()->to('/admin/artikel')->with('message', 'Artikel deleted successfully.');
        } else {
            return redirect()->to('/admin/artikel')->with('error', 'Failed to delete artikel.');
        }
    }

    public function redirect_article($id)
    {
        $desaModel = new DesaModel();
        $village   = $desaModel->find($this->artikelModel->find($id)['desa_id']);
        $artikel =  $this->artikelModel->find($id);
        return redirect()->to(base_url($village['permalink'] . '/artikel/' . $id));
    }
}
