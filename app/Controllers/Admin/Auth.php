<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admins;
use App\Models\AdminPermissionModel;
use Exception;

class Auth extends BaseController
{


    public function login()
    {
        try {
            // Already logged in
            if (session()->get('logged_in') && session()->get('role') === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            return view('Admin/auth/login');

        } catch (Exception $e) {
            log_message('error', 'Admin login page error: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'Something went wrong');
        }
    }

    public function loginPost()
    {
        try {
            $session = session();
            $model = new Admins();

            $email = trim($this->request->getPost('email'));
            $password = $this->request->getPost('password');

            // Input validation
            if (empty($email) || empty($password)) {
                log_message('warning', 'Admin login validation failed: empty fields');
                return redirect()->back()->with('error', 'All fields are required');
            }

            // Fetch admin
            $admin = $model->where('email', $email)->first();

            if (!$admin) {
                log_message('warning', 'Admin login failed: email not found - ' . $email);
                return redirect()->back()->with('error', 'Invalid credentials');
            }

            // Password check
            if (!password_verify($password, $admin['password'])) {
                log_message('warning', 'Admin login failed: wrong password - ' . $email);
                return redirect()->back()->with('error', 'Invalid credentials:password');
            }

            // Regenerate session (security)
            $session->regenerate();

            $AdminPermissionModel = new AdminPermissionModel();
            $permissions = $AdminPermissionModel
                ->where('admin_id', $admin['id'])
                ->findAll();

            $menus = array_column($permissions, 'menu_key');

            // Set session
            $session->set([
                'admin_id' => $admin['id'],
                'role'  => $admin['role'],
                'menus'    => $menus,
                'logged_in' => true
            ]);

            log_message('info', 'Admin login success: ' . $email);

            return redirect()->to('/admin/dashboard');

        } catch (Exception $e) {
            log_message('error', 'Admin login exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'System error, try again later');
        }
    }

    public function logout()
    {
        try {
            $session = session();

            $adminId = $session->get('admin_id');

            // Remove specific session data
            $session->remove(['admin_id', 'role', 'logged_in']);

            // Destroy session
            $session->destroy();

            log_message('info', 'Admin logged out. ID: ' . $adminId);

            // Prevent caching
            return redirect()->to('/')->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma'        => 'no-cache'
            ]);

        } catch (Exception $e) {
            log_message('error', 'Admin logout error: ' . $e->getMessage());
            return redirect()->to('/admin/login')->with('error', 'Logout failed');
        }
    }
}