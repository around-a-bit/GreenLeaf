<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{


// public function before(RequestInterface $request, $arguments = null)
// {
//     if (!session()->get('logged_in')) {
//         return redirect()->to('/admin/login');
//     }

//     $role  = session('role');
//     $menus = session('menus') ?? [];

//     if ($role === 'super_admin') {
//         return;
//     }

//     $path = service('uri')->getPath();
//     $configMenus = config('Menu')->menus;

//     $matched = false;

//     foreach ($configMenus as $key => $menu) {

//         if (strpos($path, 'admin/' . $menu['route']) === 0) {

//             $matched = true;

//             if (!in_array($key, $menus)) {
//                 log_message('info', 'matched false');
//                 return redirect()->to('/');
//             }

//             return; 
//         }
//     }

//     if (!$matched) {
//         log_message('info', 'oops not matched');
//         return redirect()->to('/');
//     }
// }
public function before(RequestInterface $request, $arguments = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/');
    }

    $role  = session('role');
    $menus = session('menus') ?? [];

    // Super admin → full access
    if ($role === 'super_admin') {
        return;
    }

    log_message('info', json_encode($arguments));

    // ✅ Use route-based permission (arguments)
    if ($arguments) {

        $requiredPermission = $arguments[0];
         log_message('info', 'Permission is checking for: ' . $requiredPermission);

        if (!in_array($requiredPermission, $menus)) {
            log_message('info', 'Permission denied: ' . $requiredPermission);
            return redirect()->to('/');
        }

        return; // allowed
    }

    // ❗ If no permission defined → block (secure by default)
     log_message('info', 'If no permission defined');
    return redirect()->to('/');
}
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Not needed for now
    }
}