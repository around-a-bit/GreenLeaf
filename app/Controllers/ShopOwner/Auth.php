<?php

namespace App\Controllers\ShopOwner;

use App\Controllers\BaseController;
use App\Models\ShopOwners;

class Auth extends BaseController
{
    public function register()
    {
        return view('shopOwner/auth/register');
    }

    public function registerPost()
    {
        try {
            $Users = new ShopOwners();

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'shop_owner',
                'status' => 0
            ];

            $Users->insert($data);

            return redirect()->to('/shopOwner/login')->with('success', 'Registered successfully');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function login()
    {
        return view('shopOwner/auth/login');
    }

    public function loginPost()
    {
        try {
            $Users = new ShopOwners();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $Users->where('email', $email)
                          ->where('role', 'shop_owner')
                          ->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid credentials');
            }

            session()->set([
                'user_id' => $user['id'],
                'role' => $user['role'],
                'status'    => $user['status'],
                'logged_in' => true
            ]);
             log_message('error', 'redirect to /shop_owner/dashboard ');
            return redirect()->to('/shop_owner/dashboard');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            session()->destroy();
            return redirect()->to('/');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Logout failed');
        }
    }
}