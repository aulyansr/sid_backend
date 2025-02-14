<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class KelurahanUserSeeder extends Seeder
{
    public function run()
    {
        $users             = new UserModel();
        $config            = config('AuthGroups');
        $permissionsConfig = $config->permissions;

        $desaList = $this->db->table('desa')->select('id, nama_desa, permalink')->get()->getResult();

        foreach ($desaList as $desa) {
            $desaId = (int)($desa->id ?? 0);
            $this->createUser($users, strtolower('admin_' . $desa->permalink), 'admin_' . $desa->permalink . '@sida.id', $desaId, 'password123', 'admin', ['articles', 'galleries', 'menus', 'comments', 'kelurahan'], $permissionsConfig);
            $this->createUser($users, strtolower('op_web_' . $desa->permalink), 'op_web_' . $desa->permalink . '@sida.id', $desaId, 'password123', 'op_desa', ['articles', 'galleries', 'menus', 'comments', 'kelurahan'], $permissionsConfig);
            $this->createUser($users, strtolower('op_layanan_' . $desa->permalink), 'op_layanan_' . $desa->permalink . '@sida.id', $desaId, 'password123', 'op_kabupaten', ['kelurahan'], $permissionsConfig);
        }

        echo "Seeder untuk user kelurahan berhasil dibuat dari tabel desa.\n";
    }

    private function createUser($users, string $username, string $email, int $desaId, string $password, string $role, array $permissions, array $permissionsConfig)
    {
        try {



            $user = new User(['username' => $username, 'email' => $email, 'password' => 'password']);
            $users->save($user);
            $savedUser = $users->findById($users->getInsertID());
            $savedUser->addGroup($role);

            $this->db->table('users')->where('id', $savedUser->id)->update(['desa_id' => $desaId]);
            $this->db->table('users')->where('id', $savedUser->id)->update(['nama' => $username]);


            foreach ($permissionsConfig as $permissionKey => $description) {
                if (in_array(explode('.', $permissionKey)[0], $permissions)) {
                    $savedUser->addPermission($permissionKey);
                }
            }

            echo "User {$username} berhasil dibuat.\n";
        } catch (\Exception $e) {
            echo "Error saat membuat user {$username}: " . $e->getMessage() . "\n";
        }
    }
}
