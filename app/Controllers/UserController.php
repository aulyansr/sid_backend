<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DesaModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ShieldException;

class UserController extends BaseController
{
    protected $userModel;
    protected $desaModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->desaModel = new DesaModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('users/index', $data);
    }

    public function new()
    {
        $config = config('AuthGroups');
        $data['groups'] = $config->groups;
        $data['desaList'] = $this->desaModel->findAll();

        return view('users/new', $data);
    }

    public function store()
    {
        $users = auth()->getProvider();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'                  => 'required',
            'username'              => 'required|min_length[3]|is_unique[users.username]',
            'password'              => 'required|min_length[8]',
            'password_confirmation' => 'required|matches[password]',
            'group'                 => 'required',
            'foto'                  => [
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
            'desa_id' => $this->request->getVar('desa_id'),
        ];

        try {
            // Create and save the user
            $user = new User($data);
            if ($users->save($user)) {
                $savedUser = $users->findById($users->getInsertID());

                // Add the user to the specified group
                $savedUser->addGroup($this->request->getVar('group'));

                // Assign "Articles" and "Galleries" permissions
                $config = config('AuthGroups');
                $permissionsConfig = $config->permissions;

                foreach ($permissionsConfig as $permissionKey => $description) {
                    if (
                        strpos($permissionKey, 'articles.') === 0 ||
                        strpos($permissionKey, 'galleries.') === 0 ||
                        strpos($permissionKey, 'comments.') === 0 ||
                        strpos($permissionKey, 'menus.') === 0
                    ) {
                        $savedUser->addPermission($permissionKey);
                    }
                }


                return redirect()->to('/admin/users')->with('message', 'User created successfully.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to save the user.');
            }
        } catch (ShieldException $e) {
            return redirect()->back()->withInput()->with('error', "Error during user creation: " . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $config         = config('AuthGroups');
        $data['user']   = $this->userModel->find($id);
        $data['groups'] = $config->groups;
        $data['desaList'] = $this->desaModel->findAll();

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
            'desa_id' => $this->request->getVar('desa_id'),
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

    public function permission($id)
    {

        $config = config('AuthGroups');
        $data['user'] = $this->userModel->find($id);
        $data['permissions'] = $config->permissions;


        return view('users/permission', $data);
    }

    public function add_permission($id)
    {

        $user = $this->userModel->find($id);
        $permission = $this->request->getPost('permissions') ?? [];
        $user->syncPermissions(...$permission);


        // Redirect back with a success message
        return redirect()->to('/admin/users');
    }
}
