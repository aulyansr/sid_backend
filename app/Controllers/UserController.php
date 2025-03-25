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
        $currentUser = auth()->user();

        if ($currentUser->inGroup('superadmin')) {
            $data['users'] = $this->userModel->findAll();
        } else {
            $data['users'] = $this->userModel
                ->where('users.desa_id', $currentUser->desa_id)
                ->findAll();
        }

        return view('users/index', $data);
    }

    public function new()
    {
        $config = config('AuthGroups');
        $data['groups'] = $config->groups;
        $data['desaList'] = $this->desaModel->findAll();
        $data['list_desa'] = $this->desaModel->findAll();

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
            'desa_id'  => $this->request->getVar('desa_id') ?: 0,
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
        $id    = $this->request->getPost('id');
        $users = auth()->getProvider();

        try {
            // Ambil user lama untuk mendapatkan password lama jika tidak diubah
            $existingUser = $this->userModel->find($id);
            if (!$existingUser) {
                throw new \Exception('User tidak ditemukan.');
            }

            // Handle file upload
            $image = $this->request->getFile('foto');
            if ($image && $image->isValid() && !$image->hasMoved()) {
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
                    throw new \Exception(implode(', ', $validation->getErrors()));
                }

                $newName = $image->getRandomName();
                $image->move('uploads', $newName);
                $fotoPath = 'uploads/' . $newName;
            }

            // Periksa apakah ada input password baru
            $password     = $this->request->getPost('password');
            $existingUser = auth()->user()->fill([
                'password' => $this->request->getPost('password')
            ]);

            $data = [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'nama'     => $this->request->getPost('nama'),
                'desa_id'  => $this->request->getVar('desa_id') ?: null
            ];

            if (isset($fotoPath)) {
                $data['foto'] = $fotoPath;
            }
            $users->save($existingUser);

            // Update user data
            if (!$this->userModel->update($id, $data)) {
                throw new \Exception('Gagal memperbarui data pengguna.');
            }


            // Update user group
            $user = $users->findById($id);
            if (!$user) {
                throw new \Exception('User tidak ditemukan untuk sinkronisasi grup.');
            }

            $user->syncGroups($this->request->getPost('group'));

            session()->setFlashdata('message', 'User updated successfully.');
            return redirect()->to('/admin/users');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
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
