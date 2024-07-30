<?php

namespace App\Controllers;

use App\Models\MediaSosialModel;
use App\Controllers\BaseController;

class MediaSosialController extends BaseController
{
    protected $medsos;

    public function __construct()
    {
        $this->medsos = new MediaSosialModel();
    }

    public function index()
    {
        $data['media_socials'] = $this->medsos->findAll();
        return view('media_social/index', $data);
    }

    public function new()
    {

        return view('media_social/new');
    }

    public function store()
    {
        $image = $this->request->getFile('gambar');
        $validation = \Config\Services::validation();
        $gambarpath = null;

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

            // Move the file to the uploads directory
            $newName = $image->getRandomName();
            $image->move('uploads', $newName);
            $gambarpath = 'uploads/' . $newName;
        }

        // Gather data for insertion
        $data = [
            'link' => $this->request->getVar('link'),
            'nama' => $this->request->getVar('nama'),
            'enabled' => $this->request->getVar('enabled'),
            'gambar' => $gambarpath
        ];

        // Save the data using the model
        if ($this->medsos->save($data)) {
            return redirect()->to('/admin/media_sosial')->with('message', 'Media Sosial added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->medsos->errors());
        }
    }


    public function edit($id)
    {
        $data['medsos'] = $this->medsos->find($id);
        return view('media_social/edit', $data);
    }

    public function show($id)
    {
        $data['medsos'] = $this->medsos->find($id);
        return view('media_sosial/show', $data);
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

        if (!$this->medsos->find($id)) {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Invalid ID']);
        }

        $data = [
            'link' => $this->request->getPost('link'),
            'nama' => $this->request->getPost('nama'),
            'enabled' => $this->request->getPost('enabled'),
        ];

        if ($gambarpath) {
            $data['gambar'] = $gambarpath;
        }

        $result = $this->medsos->update($id, $data);
        $message = $result ? 'Media Sosial updated successfully.' : 'Update failed';
        $redirect = $result ? '/admin/media_sosial' : 'back';

        return redirect()->to($redirect)->with('message', $message)->withInput();
    }


    public function delete($id)
    {
        // Retrieve the record by ID
        $medsos = $this->medsos->find($id);

        if (!$medsos) {
            // If the record does not exist, set an error message and redirect back
            session()->setFlashdata('error', 'Media Sosial not found.');
            return redirect()->to('/admin/media_social');
        }

        try {
            // Delete the record and the associated file
            if (!empty($medsos['gambar'])) {
                // Check if the image exists and delete it
                if (file_exists($medsos['gambar'])) {
                    unlink($medsos['gambar']);
                }
            }

            // Delete the record from the database
            $this->medsos->delete($id);

            // Set a success message
            session()->setFlashdata('message', 'Media Sosial deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors that occur during deletion
            session()->setFlashdata('error', 'Error deleting Media Sosial: ' . $e->getMessage());
        }

        // Redirect to the media_social page
        return redirect()->to('/admin/media_sosial');
    }
}
