<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ShieldException;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();
        // Define user data
        $userData = [
            'username' => 'superadmin',
            'email'    => 'superadmin@sida.id',
            'password' => 'password',
        ];

        // Create a new user entity
        $user = new User($userData);

        // Get the User Provider (UserModel by default)


        try {
            // Save the user and get the result
            $users->save($user);
            $user = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($user);
        } catch (\Exception $e) {
            // Handle exceptions thrown by Shields
            echo "Error during user creation: " . $e->getMessage() . "\n";
        }
    }
}
