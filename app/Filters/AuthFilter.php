<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
public function before(RequestInterface $request, $arguments = null)
{
    // Not logged in
    if (!session()->get('logged_in')) {
        return redirect()->to('/');
    }

    $role = session('role');

    // Role-based restriction
    if ($arguments) {

        if (empty($role) || !in_array($role, $arguments)) {

            switch ($role) {
                case 'super_admin':
                case 'sub_admin':
                    return redirect()->to('/admin/dashboard');

                case 'customer':
                    return redirect()->to('/customer/dashboard');

                case 'shop_owner':
                    return redirect()->to('/shopOwner/dashboard');

                case 'delivery':
                    return redirect()->to('/delivery/dashboard');

                default:
                    return redirect()->to('/');
            }
        }
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No need
    }
}