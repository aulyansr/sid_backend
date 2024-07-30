<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class KategoriController extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data['kategoris'] = $this->kategori->findAll();
        $data['activeTab'] = 'kategori';
        return view('kategori/index', $data);
    }

    public function new()
    {

        $data['kategoris'] = $this->kategori->findAll(); // Fetch all kategori items for the parent dropdown

        return view('kategori/new', $data);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'kategori' => 'required|string|max_length[100]',
            'tipe' => 'required|integer',
            'urut' => 'required|integer',
            'enabled' => 'required|integer',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kategori' => $this->request->getVar('kategori'),
            'tipe' => $this->request->getVar('tipe'),
            'urut' => $this->request->getVar('urut'),
            'enabled' => $this->request->getVar('enabled'),
            'parrent' => $this->request->getVar('parrent'),
        ];

        // Save the data using the model
        if ($this->kategori->save($data)) {
            return redirect()->to('/admin/kategori')->with('message', 'Kategori added successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->kategori->errors());
        }
    }


    public function edit($id)
    {
        $data['kategori'] = $this->kategori->find($id);
        $data['kategoris'] = $this->kategori->findAll();
        if (!$data['kategori']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('kategori not found');
        }
        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        if ($this->validate([
            'kategori' => 'required|string|max_length[100]',
            'tipe' => 'required|integer',
            'urut' => 'required|integer',
            'enabled' => 'required|integer',
        ])) {
            $this->kategori->update($id, $data);
            return redirect()->to('/admin/kategori')->with('message', 'kategori updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function delete($id)
    {
        try {
            $this->kategori->delete($id);
            return redirect()->to('/admin/kategori')->with('message', 'kategori deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting kategori: ' . $e->getMessage());
        }
    }
}
