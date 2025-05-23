<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        // Ensure full_name is included in allowedFields
        $this->allowedFields = [
            ...$this->allowedFields,
            'username',
            'password',
            'email',
            'nama',
            'phone',
            'foto',
            'session',
            'desa_id'
        ];
    }
}
