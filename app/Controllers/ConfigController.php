<?php

namespace App\Controllers;

use App\Models\ConfigModel;
use App\Controllers\BaseController;

class ConfigController extends BaseController
{
    protected $configModel;

    public function __construct()
    {
        $this->configModel = new ConfigModel();
    }

    public function index()
    {
        $data['configs'] = $this->configModel->findAll();
        return view('config/index', $data);
    }

    public function edit($id)
    {
        $data['config'] = $this->configModel->find($id);
        return view('config/edit', $data);
    }

    public function show($id)
    {
        $data['config'] = $this->configModel->find($id);
        return view('config/show', $data);
    }

    public function update($id)
    {


        $id = $this->request->getPost('id');

        $image = $this->request->getFile('logo');
        if ($image && $image->isValid()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'logo' => [
                    'rules' => 'uploaded[logo]'
                        . '|is_image[logo]'
                        . '|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[logo,1000]'
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $newName = $image->getRandomName();
            $image->move('uploads', $newName);
            $logopath = 'uploads/' . $newName;
        }


        $data = [
            'nama_desa' => $this->request->getPost('nama_desa'),
            'kode_desa' => $this->request->getPost('kode_desa'),
            'nama_kepala_desa' => $this->request->getPost('nama_kepala_desa'),
            'nip_kepala_desa' => $this->request->getPost('nip_kepala_desa'),
            'kode_pos' => $this->request->getPost('kode_pos'),
            'email_desa' => $this->request->getPost('email_desa'),
            'regid' => $this->request->getPost('regid'),
            'macid' => $this->request->getPost('macid'),
            'nama_kecamatan' => $this->request->getPost('nama_kecamatan'),
            'kode_kecamatan' => $this->request->getPost('kode_kecamatan'),
            'nama_kepala_camat' => $this->request->getPost('nama_kepala_camat'),
            'nip_kepala_camat' => $this->request->getPost('nip_kepala_camat'),
            'nama_kabupaten' => $this->request->getPost('nama_kabupaten'),
            'kode_kabupaten' => $this->request->getPost('kode_kabupaten'),
            'nama_propinsi' => $this->request->getPost('nama_propinsi'),
            'kode_propinsi' => $this->request->getPost('kode_propinsi'),
            'lat' => $this->request->getPost('lat'),
            'lng' => $this->request->getPost('lng'),
            'zoom' => $this->request->getPost('zoom'),
            'map_tipe' => $this->request->getPost('map_tipe'),
            'path' => $this->request->getPost('path'),
            'gapi_key' => $this->request->getPost('gapi_key'),
            'alamat_kantor' => $this->request->getPost('alamat_kantor'),
            'g_analytic' => $this->request->getPost('g_analytic'),
            'logo' => $logopath
        ];

        if (empty($id)) {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Invalid ID']);
        }


        // Update the record in the database
        if ($this->configModel->update($id, $data)) {
            return redirect()->to('/admin/config')->with('message', 'Configuration updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Update failed']);
        }
    }

    // If not a POST request, redirect to edit page


}
