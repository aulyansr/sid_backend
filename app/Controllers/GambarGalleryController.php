<?php

namespace App\Controllers;

use App\Models\GambarGalleryModel;
use CodeIgniter\Controller;
use App\Models\DesaModel;

class GambarGalleryController extends BaseController

{
    protected $gambarGallery;
    protected $desaModel;

    public function __construct()
    {
        $this->gambarGallery = new GambarGalleryModel();
        $this->desaModel = new DesaModel();
    }

    public function index()
    {
        $model = new GambarGalleryModel();
        if (auth()->user()->inGroup('superadmin')) {
            $data['gambar_galleries'] = $model->getGalleriesByType(0);
        } else {
            $data['gambar_galleries'] = $model
                ->where('desa_id', auth()->user()->desa_id)
                ->getGalleriesByType(0);
        }

        $data['activeTab'] = 'gambar-gallery';

        return view('gambar_gallery/index', $data);
    }

    public function new()
    {
        $desaModel         = new DesaModel();
        $data['list_desa'] =  $desaModel->findAll();
        return view('gambar_gallery/new', $data);
    }

    public function add_image()
    {
        // Get the parent ID from the query parameter
        $parent_id = $this->request->getGet('parrent_id');

        // Validate parent ID
        if ($parent_id && is_numeric($parent_id)) {
            // Fetch parent details if a parent ID is valid
            $parent = $this->gambarGallery->find($parent_id);

            // Check if parent exists
            if (!$parent) {
                return redirect()->to('/admin/gambar-gallery')->with('error', 'Parent gallery not found.');
            }

            $data = [
                'parrent' => $parent,
                'parent_id' => $parent_id,
                'validation' => \Config\Services::validation(),
            ];


            return view('gambar_gallery/add_image', $data);
        } else {
            // Redirect to a different page if parent_id is invalid
            return redirect()->to('/admin/gambar-gallery')->with('error', 'Invalid parent ID.');
        }
    }



    public function store()
    {
        $image = $this->request->getFile('gambar');
        $validation = \Config\Services::validation();


        // Validate the uploaded image
        if ($image && $image->isValid()) {
            $validation->setRules([
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
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $random_id =  (new \DateTime())->format('YmdHis');
            $uploadPath = 'uploads/gallery/' . $random_id;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the main image
            $newName = $image->getRandomName();
            $image->move($uploadPath, $newName);
            $gambarpath = $uploadPath . '/' . $newName;

            $imageService = \Config\Services::image()
                ->withFile($gambarpath)
                ->fit(660, 360) // Crop the image to 160x160
                ->save($uploadPath . '/thumb_' . $newName);
        }

        // Gather data for insertion
        $data = [
            'parrent'    => $this->request->getVar('parrent') ? $this->request->getVar('parrent') : null,
            'gambar'     => $gambarpath,
            'nama'       => $this->request->getVar('nama'),
            'enabled'    => $this->request->getVar('enabled'),
            'tgl_upload' => $this->request->getVar('tgl_upload'),
            'tipe'       => $this->request->getVar('tipe'),
            'desa_id' => $this->request->getVar('desa_id')
        ];

        // Save the data using the model
        if ($this->gambarGallery->save($data)) {

            if ($data['tipe'] == 0) {
                return redirect()->to('/admin/gambar-gallery/' . $this->gambarGallery->getInsertID())->with('message', 'Gambar Gallery added successfully.');
            } else {
                return redirect()->to('/admin/gambar-gallery/' . $data['parrent'])->with('message', 'Gambar Gallery added successfully.');
            }
        } else {
            return redirect()->back()->withInput()->with('errors', $this->gambarGallery->errors());
        }
    }


    public function edit($id)
    {
        $model                  = new GambarGalleryModel();
        $data['gambar_gallery'] = $model->find($id);
        $desaModel              = new DesaModel();
        $data['list_desa']      = $desaModel->findAll();

        return view('gambar_gallery/edit', $data);
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


        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Fetch existing article data
        $gambarGallery = $this->gambarGallery->find($id);

        if (!$gambarGallery) {
            return redirect()->back()->with('error', 'Gambar Gallery not found.');
        }

        $uploadPath = 'uploads/gallery/' . $id;

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $gambarpath = $gambarGallery['gambar']; // Default to existing image path
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

        // Gather data for update
        $data = [
            'parrent'    => $this->request->getPost('parrent') ? $this->request->getPost('parrent') : null,
            'gambar'     => $gambarpath,
            'nama'       => $this->request->getPost('nama'),
            'enabled'    => $this->request->getPost('enabled'),
            'tgl_upload' => $this->request->getPost('tgl_upload'),
            'tipe'       => $this->request->getPost('tipe'),
            'desa_id' => $this->request->getVar('desa_id')
        ];

        // Save the updated data using the model
        if ($this->gambarGallery->update($id, $data)) {
            return redirect()->to('/admin/gambar-gallery')->with('message', 'Gambar Gallery updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->gambarGallery->errors());
        }
    }


    public function delete($id)
    {
        $model = new GambarGalleryModel();
        $model->delete($id);

        return redirect()->to('admin/gambar-gallery');
    }

    public function views($id)
    {
        $model = new GambarGalleryModel();
        $data['gambar_gallery'] = $model->find($id);
        $data['images'] = $model->where('parrent', $id)->findAll();

        return view('gambar_gallery/view', $data);
    }

    public function show($segment, $id)
    {

        $model = new GambarGalleryModel();
        $data['gambar_gallery'] = $model->find($id);
        $data['images'] = $model->where('parrent', $id)->findAll();
        return view('gambar_gallery/show', $data);
    }
}
