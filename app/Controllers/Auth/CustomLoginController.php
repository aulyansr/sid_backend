<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class CustomLoginController extends BaseController
{
    public function login(): RedirectResponse
    {
        $request = service('request');

        // Accept either username or email from the same input field
        $identity = (string) $request->getPost('username');
        $password = (string) $request->getPost('password');
        $remember = (bool) $request->getPost('remember');

        $credentials = [
            'username' => $identity,
            'email'    => $identity,
            'password' => $password,
        ];

        $result = auth()->attempt($credentials, $remember);

        // Always return a generic error message to prevent username/email enumeration
        if (! $result->isOK()) {
            return redirect()->back()->withInput()->with('error', 'Kredensial tidak valid.');
        }

        return redirect()->to(config('Auth')->loginRedirect());
    }
}
