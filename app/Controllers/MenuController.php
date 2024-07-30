<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\HTTP\ResponseInterface;

class MenuController extends BaseController
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    public function index()
    {
        $data['menus'] = $this->menu->findAll();
        return view('menu/index', $data);
    }

    public function new()
    {

        $data['menus'] = $this->menu->findAll(); // Fetch all menu items for the parent dropdown

        return view('menu/new', $data);
    }

    public function store()
    {
        $ikon = $this->request->getFile('ikon');
        $validation = \Config\Services::validation();
        $ikonpath = null;

        // Validate the uploaded image
        if ($ikon && $ikon->isValid()) {
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
            $newName = $ikon->getRandomName();
            $ikon->move('uploads', $newName);
            $ikonpath = 'uploads/' . $newName;
        }
        // Gather data for insertion
        $data = [
            'link' => $this->request->getVar('link'),
            'nama' => $this->request->getVar('nama'),
            'tipe' => $this->request->getVar('tipe'),
            // 'parrent' => $this->request->getVar('parrent'),
            'enabled' => $this->request->getVar('enabled'),
            'link_tipe' => $this->request->getVar('link_tipe'),
            'ikon' => $ikonpath
        ];

        // Save the data using the model
        if ($this->menu->save($data)) {
            return redirect()->to('/admin/menu')->with('message', 'Media Sosial added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->menu->errors());
        }
    }

    public function edit($id)
    {
        $data['menu'] = $this->menu->find($id);
        if (!$data['menu']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Menu not found');
        }
        return view('menu/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        if ($this->validate([
            'nama' => 'required|max_length[50]',
            'link' => 'required|max_length[500]',
            'tipe' => 'required|integer',
            'parrent' => 'permit_empty|integer',
            'link_tipe' => 'required|integer|in_list[0,1]',
            'enabled' => 'required|integer',
        ])) {
            $this->menu->update($id, $data);
            return redirect()->to('/admin/menu')->with('message', 'Menu updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        try {
            $this->menu->delete($id);
            return redirect()->to('/admin/menu')->with('message', 'Menu deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting menu: ' . $e->getMessage());
        }
    }
}
