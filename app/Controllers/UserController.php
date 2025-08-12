<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DesaModel;
use CodeIgniter\Shield\Entities\User;
// use CodeIgniter\Shield\Exceptions\ShieldException;
use CodeIgniter\HTTP\IncomingRequest;

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
        /** @var \Config\AuthGroups $config */
        $config = config('AuthGroups');
        $data['groups'] = $config->groups;
        $data['desaList'] = $this->desaModel->findAll();

        return view('users/new', $data);
    }

    public function store()
    {
        $users = auth()->getProvider();
        /** @var IncomingRequest $request */
        $request = service('request');

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

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload
        $image = $request->getFile('foto');
        $newName = $image->getRandomName();
        $image->move('uploads', $newName);
        $fotoPath = 'uploads/' . $newName;

        $data = [
            'username' => $request->getVar('username'),
            'email'    => $request->getVar('email'),
            'nama'     => $request->getVar('nama'),
            'password' => $request->getVar('password'),
            'foto'     => $fotoPath,
        ];

        $currentUser = auth()->user();

        // Handle desa_id: superadmin can set any desa_id, others are locked to their own
        if (!$currentUser->inGroup('superadmin')) {
            $data['desa_id'] = (int) ($currentUser->desa_id ?? 0);
        } else {
            // Superadmin can set desa_id or leave it null (access to all)
            $data['desa_id'] = $request->getVar('desa_id') ? (int) $request->getVar('desa_id') : null;
        }

        // Validate requested role and permission to assign it
        $requestedGroup = (string) $request->getVar('group');
        /** @var \Config\AuthGroups $config */
        $config = config('AuthGroups');
        if (!array_key_exists($requestedGroup, $config->groups)) {
            return redirect()->back()->withInput()->with('error', 'Grup tidak valid.');
        }
        // Only users with users.roles permission can assign roles
        if (!$currentUser->can('users.roles')) {
            return redirect()->back()->withInput()->with('error', 'Anda tidak memiliki izin untuk mengatur peran.');
        }
        // Prevent assigning superadmin unless actor is superadmin
        if ($requestedGroup === 'superadmin' && !$currentUser->inGroup('superadmin')) {
            return redirect()->back()->withInput()->with('error', 'Tidak dapat menetapkan peran superadmin.');
        }

        try {
            // Create and save the user
            $user = new User($data);
            if ($users->save($user)) {
                $savedUser = $users->findById($users->getInsertID());

                // Add the user to the specified group
                $savedUser->syncGroups($requestedGroup);

                // Assign "Articles" and "Galleries" permissions
                /** @var \Config\AuthGroups $config */
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
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', "Error during user creation: " . $e->getMessage());
        }
    }

    public function edit($id)
    {
        /** @var \Config\AuthGroups $config */
        $config         = config('AuthGroups');
        $data['user']   = $this->userModel->find($id);
        $data['groups'] = $config->groups;
        $data['desaList'] = $this->desaModel->findAll();

        return view('users/edit', $data);
    }

    public function update()
    {
        /** @var IncomingRequest $request */
        $request = service('request');
        $id    = $request->getPost('id');
        $users = auth()->getProvider();

        try {
            // Ambil user lama untuk mendapatkan password lama jika tidak diubah
            $existingUser = $this->userModel->find($id);
            if (!$existingUser) {
                throw new \Exception('User tidak ditemukan.');
            }

            // Handle file upload
            $image = $request->getFile('foto');
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

                if (!$validation->withRequest($request)->run()) {
                    throw new \Exception(implode(', ', $validation->getErrors()));
                }

                $newName = $image->getRandomName();
                $image->move('uploads', $newName);
                $fotoPath = 'uploads/' . $newName;
            }

            // Periksa apakah ada input password baru
            $newPassword = (string) $request->getPost('password');
            if ($newPassword !== '') {
                $targetShieldUser = $users->findById($id);
                if (!$targetShieldUser) {
                    throw new \Exception('User tidak ditemukan untuk pembaruan sandi.');
                }
                $targetShieldUser->fill(['password' => $newPassword]);
                $users->save($targetShieldUser);
            }

            $data = [
                'username' => $request->getPost('username'),
                'email'    => $request->getPost('email'),
                'nama'     => $request->getPost('nama'),
            ];

            // Handle desa_id: superadmin can set any desa_id, others are locked to their own
            $currentUser = auth()->user();
            if ($currentUser->inGroup('superadmin')) {
                // Superadmin can set any desa_id or leave it null (access to all)
                $data['desa_id'] = $request->getVar('desa_id') ? (int) $request->getVar('desa_id') : null;
            } else {
                // Lock to current user's desa
                $data['desa_id'] = (int) ($currentUser->desa_id ?? 0);
            }

            if (isset($fotoPath)) {
                $data['foto'] = $fotoPath;
            }
            // Update user data
            if (!$this->userModel->update($id, $data)) {
                throw new \Exception('Gagal memperbarui data pengguna.');
            }

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
        /** @var \Config\AuthGroups $config */
        $config = config('AuthGroups');
        $data['user'] = $this->userModel->find($id);
        $data['permissions'] = $config->permissions;


        return view('users/permission', $data);
    }

    public function add_permission($id)
    {
        /** @var IncomingRequest $request */
        $request = service('request');
        $user = $this->userModel->find($id);
        $permission = $request->getPost('permissions') ?? [];
        $user->syncPermissions(...$permission);


        // Redirect back with a success message
        return redirect()->to('/admin/users');
    }

    public function changeRole($id)
    {
        /** @var IncomingRequest $request */
        $request = service('request');

        $currentUser = auth()->user();
        // Double-check permission on server-side
        if (!$currentUser->can('users.roles')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah peran.');
        }

        $targetUser = $this->userModel->find($id);
        if (!$targetUser) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $requestedGroup = (string) $request->getPost('group');
        /** @var \Config\AuthGroups $config */
        $config = config('AuthGroups');
        if (!array_key_exists($requestedGroup, $config->groups)) {
            return redirect()->back()->with('error', 'Grup tidak valid.');
        }

        // Prevent changing own role unless superadmin
        if ((int) $currentUser->id === (int) $targetUser->id && !$currentUser->inGroup('superadmin')) {
            return redirect()->back()->with('error', 'Tidak dapat mengubah peran akun sendiri.');
        }

        // Prevent assigning/removing superadmin unless actor is superadmin
        if ($requestedGroup === 'superadmin' && !$currentUser->inGroup('superadmin')) {
            return redirect()->back()->with('error', 'Tidak dapat menetapkan peran superadmin.');
        }

        try {
            $shieldProvider = auth()->getProvider();
            $shieldUser = $shieldProvider->findById($id);
            if (!$shieldUser) {
                throw new \RuntimeException('User Shield tidak ditemukan.');
            }
            $shieldUser->syncGroups($requestedGroup);

            session()->setFlashdata('message', 'Peran pengguna berhasil diperbarui.');
            return redirect()->to('/admin/users');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui peran: ' . $e->getMessage());
        }
    }
}
