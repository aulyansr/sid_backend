<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class RehashPasswordSeeder extends Seeder
{
public function run()
    {
        $userModel = new UserModel();

        // Fetch all users from the database
        $users = $userModel->findAll();

        // Set a default password to be used for all users
        $defaultPassword = 'DefaultPassword123'; // Change this to your desired default password
        $hashedPassword = md5($defaultPassword);

        foreach ($users as $user) {
            if ($user) {
                // Check if the password is empty or not set
                if (empty($user->password)) {
                    // Directly update the user's password with the hashed password
                    $userModel->update($user->id, ['password' => $hashedPassword]);

                    echo "Default password set for user ID: {$user->id}" . PHP_EOL;
                } else {
                    echo "User ID: {$user->id} already has a password." . PHP_EOL;
                }
            } else {
                echo "Invalid user entity." . PHP_EOL;
            }
        } 
}

}
