<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use CodeIgniter\Controller;
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

        // Get the groups from the config
        $data = [
            'groups'  => $config->groups,
        ];
        return view('users/new', $data);
    }

    public function store()
    {
        $users = auth()->getProvider();

        // Validation
        $validation = \Config\Services::validation();

        $validation->setRules([
            'full_name' => 'required',
            'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'password_confirmation' => 'required|matches[password]',
            'group' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'full_name' => $this->request->getVar('full_name'),
            'password' => $this->request->getVar('password')
        ];

        $user = new User($data);

        try {
            // Save the user
            $users->save($user);

            // Assign user to group
            $userId =  $users->findById($users->getInsertID());
            $group = $this->request->getVar('group');

            $userId->addGroup($group);

            return redirect()->to('/admin/users')->with('message', 'User created successfully.');
        } catch (ShieldException $e) {
            // Handle exceptions thrown by Shields
            return redirect()->back()->withInput()->with('error', "Error during user creation: " . $e->getMessage());
        }
    }


    public function edit($id = null)
    {
        $config = config('AuthGroups');
        $data['user'] = $this->userModel->find($id);
        $data['groups'] = $config->groups;

        return view('users/edit', $data);
    }

    public function update()
    {
        // Get the ID of the user to be updated
        $id = $this->request->getPost('id');

        // Get the user provider from the auth library
        $users = auth()->getProvider();

        // Prepare the data array for updating the user
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'password'  => $this->request->getVar('password')
        ];

        // Update the user in the database
        $this->userModel->update($id, $data);

        // Get the group to which the user should be assigned
        $group = $this->request->getVar('group');

        // Find the user by ID and sync their groups
        $userId = $users->findById($id);
        $userId->syncGroups($group);

        // Set a flashdata message indicating success
        session()->setFlashdata('message', 'Pengguna Berhasil di Ubah');

        // Redirect to the users admin page
        return redirect()->to('/admin/users');
    }


    public function delete($id = null)
    {
        $users = auth()->getProvider();
        $users->delete($id, true);

        session()->setFlashdata('message', 'Pengguna Berhasil di Hapus');

        return redirect()->to('/admin/users');
    }
}
