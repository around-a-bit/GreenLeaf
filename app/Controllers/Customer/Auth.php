<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\Users;

class Auth extends BaseController
{
    public function login()
    {
        return view('customer/auth/login');
    }

    public function loginPost()
    {
        try {
            $model = new Users();

            $email = trim($this->request->getPost('email'));
            $password = $this->request->getPost('password');

            log_message('info', 'Customer login attempt: ' . $email);

            $user = $model->where('email', $email)
                ->where('role', 'customer')
                ->first();

            if (!$user) {
                log_message('warning', 'Login failed - user not found: ' . $email);
                return redirect()->back()->with('error', 'Invalid credentials');
            }

            if (!password_verify($password, $user['password'])) {
                log_message('warning', 'Login failed - wrong password: ' . $email);
                return redirect()->back()->with('error', 'Invalid credentials');
            }
            $menuConfig = config(\Config\CustomerMenu::class)->menus;

            $menuKeys = array_keys($menuConfig);


            // ✅ Session
            session()->set([
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => 'customer',
                'menus' => $menuKeys,
                'logged_in' => true
            ]);


            log_message('info', 'Customer login success: ID ' . $user['id']);

            return redirect()->to('/customer/dashboard');
        } catch (\Exception $e) {

            log_message('error', 'Login Exception: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong. Try again.');
        }
    }

    public function register()
    {
        return view('customer/auth/register');
    }

    public function registerPost()
    {
        try {
            $model = new Users();

            $data = [
                'name' => trim($this->request->getPost('name')),
                'email' => trim($this->request->getPost('email')),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'customer',
                'status' => 1
            ];

            // 🔍 Check duplicate email
            $exists = $model->where('email', $data['email'])->first();

            if ($exists) {
                log_message('warning', 'Registration failed - email exists: ' . $data['email']);
                return redirect()->back()->with('error', 'Email already registered');
            }

            $model->insert($data);

            log_message('info', 'Customer registered: ' . $data['email']);

            return redirect()->to('/customer/login')->with('success', 'Registered successfully');
        } catch (\Exception $e) {

            log_message('error', 'Register Exception: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong. Try again.');
        }
    }

    public function logout()
    {
        try {
            $userId = session('id');

            session()->destroy();

            log_message('info', 'Customer logout: ID ' . $userId);

            return redirect()->to('/');
        } catch (\Exception $e) {

            log_message('error', 'Logout Exception: ' . $e->getMessage());

            return redirect()->to('/');
        }
    }
}
