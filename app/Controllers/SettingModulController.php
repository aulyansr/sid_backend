<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SettingModulModel;

class SettingModulController extends BaseController
{
    protected $settingModulModel;

    public function __construct()
    {
        $this->settingModulModel = new SettingModulModel();
    }
    public function index()
    {
        $data['setting_moduls'] = $this->settingModulModel->findAll();
        return view('setting_modul/index', $data);
    }

    public function new()
    {
        return view('setting_modul/new');
    }

    public function store()
    {
        $image = $this->request->getFile('ikon');
        $validation = \Config\Services::validation();
        $ikonpath = null;

        // Validate the uploaded image
        if ($image && $image->isValid()) {
            $validation->setRules([
                'ikon' => [
                    'rules' => 'uploaded[ikon]'
                        . '|is_image[ikon]'
                        . '|mime_in[ikon,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[ikon,1000]', // 1000 KB limit
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
            $ikonpath = 'uploads/' . $newName;
        }


        $data = [
            'modul' => $this->request->getPost('modul'),
            'url' => $this->request->getPost('url'),
            'aktif' => $this->request->getPost('aktif'),
            'ikon' => $ikonpath,
            'urut' => $this->request->getPost('urut'),
            'level' => $this->request->getPost('level'),
            'hidden' => $this->request->getPost('hidden'),
        ];

        if ($this->settingModulModel->save($data)) {
            return redirect()->to('/admin/setting_modul')->with('message', 'Setting Module added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->settingModulModel->errors());
        }
    }

    public function edit($id)
    {
        $data['setting_modul'] = $this->settingModulModel->find($id);
        return view('setting_modul/edit', $data);
    }

    public function update($id)
    {
        $image = $this->request->getFile('ikon');
        $validation = \Config\Services::validation();
        $ikonpath = null;

        if ($image && $image->isValid()) {
            $validation->setRules([
                'ikon' => [
                    'rules' => 'uploaded[ikon]'
                        . '|is_image[ikon]'
                        . '|mime_in[ikon,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[ikon,1000]'
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $newName = $image->getRandomName();
            $image->move('uploads', $newName);
            $ikonpath = 'uploads/' . $newName;
        }

        if (!$this->settingModulModel->find($id)) {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Invalid ID']);
        }
        $data = [
            'modul' => $this->request->getPost('modul'),
            'url' => $this->request->getPost('url'),
            'aktif' => $this->request->getPost('aktif'),
            'urut' => $this->request->getPost('urut'),
            'level' => $this->request->getPost('level'),
            'hidden' => $this->request->getPost('hidden'),
        ];

        if ($ikonpath) {
            $data['ikon'] = $ikonpath;
        }

        $result = $this->settingModulModel->update($id, $data);
        $message = $result ? 'Setting Module updated successfully.' : 'Update failed';
        $redirect = $result ? '/admin/setting_modul' : 'back';

        return redirect()->to($redirect)->with('message', $message)->withInput();
    }

    public function delete($id)
    {
        $result =  $this->settingModulModel->delete($id);
        $message = $result ? 'Setting Module updated successfully.' : 'Update failed';
        $redirect = $result ? '/admin/setting_modul' : 'back';

        return redirect()->to($redirect)->with('message', $message)->withInput();
    }
}
