<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ShieldException;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('users/index', $data);
    }

    public function new()
    {
        $config = config('AuthGroups');
        $data = ['groups' => $config->groups];
        return view('users/new', $data);
    }

    public function store()
    {
        $users = auth()->getProvider();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'password_confirmation' => 'required|matches[password]',
            'group' => 'required',
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]'
                    . '|is_image[foto]'
                    . '|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                    . '|max_size[foto,1000]'
                    . '|max_dims[foto,4000,4000]',
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload
        $image = $this->request->getFile('foto');
        $newName = $image->getRandomName();
        $image->move('uploads', $newName);
        $fotoPath = 'uploads/' . $newName;

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'nama'     => $this->request->getVar('nama'),
            'password' => $this->request->getVar('password'),
            'foto'     => $fotoPath,
        ];

        try {
            $user = new User($data);
            $users->save($user);
            $user->addGroup($this->request->getVar('group'));
            return redirect()->to('/admin/users')->with('message', 'User created successfully.');
        } catch (ShieldException $e) {
            return redirect()->back()->withInput()->with('error', "Error during user creation: " . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $config = config('AuthGroups');
        $data['user'] = $this->userModel->find($id);
        $data['groups'] = $config->groups;

        return view('users/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $users = auth()->getProvider();

        // Handle file upload
        $image = $this->request->getFile('foto');
        if ($image && $image->isValid()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'foto' => [
                    'rules' => 'uploaded[foto]'
                        . '|is_image[foto]'
                        . '|mime_in[foto,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[foto,1000]'
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $newName = $image->getRandomName();
            $image->move('uploads', $newName);
            $fotoPath = 'uploads/' . $newName;
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'nama'     => $this->request->getPost('nama'),
            'password' => $this->request->getPost('password'),
        ];

        if (isset($fotoPath)) {
            $data['foto'] = $fotoPath;
        }

        $this->userModel->update($id, $data);

        // Update user group
        $user = $users->findById($id);
        $user->syncGroups($this->request->getPost('group'));

        session()->setFlashdata('message', 'User updated successfully.');
        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $users = auth()->getProvider();
        try {
            $users->delete($id, true);
            session()->setFlashdata('message', 'User deleted successfully.');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error deleting user: ' . $e->getMessage());
        }
        return redirect()->to('/admin/users');
    }
}