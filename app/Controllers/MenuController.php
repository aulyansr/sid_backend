<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\DesaModel;
use CodeIgniter\HTTP\ResponseInterface;

class MenuController extends BaseController
{
    protected $menu;
    protected $db;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $desaModel   = new DesaModel();
        $currentUser = auth()->user();

        if ($currentUser->inGroup('superadmin')) {
            $data['menus'] = $this->menu->where('tipe', 1)->findAll();
        } else {
            $data['menus'] = $this->menu->where('tipe', 1)
                ->where('desa_id', $currentUser->desa_id)
                ->findAll();
        }
        $data['activeTab'] = 'menu-statis';
        return view('menu/index', $data);
    }

    public function new()
    {

        $data['menus'] = $this->menu->where('tipe', 1)->findAll(); // Fetch all menu items for the parent dropdown

        return view('menu/new', $data);
    }
    public function store()
    {
        $desaModel = new DesaModel();

        $currentUser = auth()->user();
        $desa = $desaModel->find($currentUser->desa_id);
        // Gather data for insertion
        $data = [
            'link' => $this->request->getVar('link'),
            'nama' => $this->request->getVar('nama'),
            'tipe' => 1,
            // 'parrent' => $this->request->getVar('parrent'), // Uncomment if needed
            'enabled' => 1,
            'link_tipe' => $this->request->getVar('link_tipe'),
            'desa_id' => $this->request->getVar('desa_id'),
        ];

        // Save the data using the model
        if ($this->menu->save($data)) {
            $menuId = $this->menu->insertID();

            if ($this->request->getVar('link_tipe') == 0) {
                // Prepare the article data
                $article = [
                    'judul' => $this->request->getVar('nama'),
                    'isi' => 'Pemerintah dari ' . $this->request->getVar('nama'),
                    'gambar' => 'path/to/default/image.jpg',
                    'enabled' => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline' => 1,
                    'desa_id' => $currentUser->desa_id,
                    'id_user' => $currentUser->id, // Use the logged-in user ID
                ];

                // Insert the article into the 'artikel' table
                $this->db->table('artikel')->insert($article);
                $articleId = $this->db->insertID();
            }

            // Update the 'menu' table with the new link
            $this->menu->update($menuId, ['link' => base_url($desa['permalink'] . "/artikel/" . $articleId)]);

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
        // Retrieve POST data
        $data = $this->request->getPost();
        $data['enabled'] = 1;
        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[50]',
            'link' => 'required|max_length[500]',
        ];

        // Validate input data
        if ($this->validate($validationRules)) {
            // Update menu item
            $this->menu->update($id, $data);


            // Redirect with success message
            return redirect()->to('/admin/menu')->with('message', 'Menu updated successfully.');
        } else {
            // Redirect back with input and validation errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }


    public function add_children($parent = null)
    {



        return view('menu/add', ['parent' => $parent]);
    }
    public function store_children()
    {
        $desaModel = new DesaModel();

        $currentUser = auth()->user();
        $desa = $desaModel->find($currentUser->desa_id);
        // Gather data for insertion
        $data = [
            'link'      => $this->request->getVar('link'),
            'nama'      => $this->request->getVar('nama'),
            'tipe'      => 0,
            'parrent'   => $this->request->getVar('parrent'),
            'enabled'   => 1,
            'link_tipe' => 1,

        ];

        // Save the data using the model
        if ($this->menu->save($data)) {

            $menuId = $this->menu->insertID();

            if ($this->request->getVar('link_tipe') == 0) {
                // Prepare the article data
                $article = [
                    'judul' => $this->request->getVar('nama'),
                    'isi' => 'Pemerintah dari ' . $this->request->getVar('nama'),
                    'gambar' => 'path/to/default/image.jpg',
                    'enabled' => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_kategori' => 1,
                    'headline' => 1,
                    'desa_id' => $currentUser->desa_id,
                    'id_user' => $currentUser->id, // Use the logged-in user ID
                ];

                // Insert the article into the 'artikel' table
                $this->db->table('artikel')->insert($article);
                $articleId = $this->db->insertID();
            }

            // Update the 'menu' table with the new link
            $this->menu->update($menuId, ['link' => base_url($desa['permalink'] . "/artikel/" . $articleId)]);

            return redirect()->to('/admin/menu')->with('message', 'Media Sosial added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->menu->errors());
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

    public function show($id)
    {

        $data['menu'] = $this->menu->find($id);
        $data['children'] =  $this->menu->where('parrent', $id)->findAll();
        $data['activeTab'] = 'menu-statis';

        return view('menu/show', $data);
    }
}
