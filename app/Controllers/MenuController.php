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
        $data['menus'] = $this->menu->where('tipe', 1)->findAll();
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

        // Gather data for insertion
        $data = [
            'link' => $this->request->getVar('link'),
            'nama' => $this->request->getVar('nama'),
            'tipe' => 1,
            // 'parrent' => $this->request->getVar('parrent'),
            'enabled' => $this->request->getVar('enabled'),
            'link_tipe' => 1,

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
        // Retrieve POST data
        $data = $this->request->getPost();

        // Validation rules
        $validationRules = [
            'nama' => 'required|max_length[50]',
            'link' => 'required|max_length[500]',
            'enabled' => 'required|in_list[0,1]',
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

        // Gather data for insertion
        $data = [
            'link' => $this->request->getVar('link'),
            'nama' => $this->request->getVar('nama'),
            'tipe' => 0,
            'parrent' => $this->request->getVar('parrent'),
            'enabled' => $this->request->getVar('enabled'),
            'link_tipe' => 1,

        ];

        // Save the data using the model
        if ($this->menu->save($data)) {
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
