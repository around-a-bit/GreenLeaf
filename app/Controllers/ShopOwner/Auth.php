<?php

namespace App\Controllers\ShopOwner;

use App\Controllers\BaseController;
use App\Models\Users;

class Auth extends BaseController
{
    public function register()
    {
        return view('shopOwner/auth/register');
    }

    public function registerPost()
    {
        try {
            $Users = new Users();

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'shop_owner',
                'status' => 1
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
            $Users = new Users();

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
                'isLoggedIn' => true
            ]);

            return redirect()->to('/shop/dashboard');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            session()->destroy();
            return redirect()->to('/shopOwner/login');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Logout failed');
        }
    }
}