<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admins;
use App\Models\AdminPermissionModel;

class AdminController extends BaseController
{
    public function index()
    {
        $adminModel = new Admins();
        $data['admins'] = $adminModel->findAll();

        return view('admin/AdminControl/index', $data);
    }

    public function create()
    {
        $config = config('Menu');
        $data['menus'] = $config->menus;

        return view('admin/AdminControl/create', $data);
    }

    public function store()
    {
        $adminModel = new Admins();
        $permModel = new AdminPermissionModel();

        $adminId = $adminModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'sub_admin',
            'status' => 'active'
        ]);

        $menus = $this->request->getPost('menus');

        if ($menus) {
            foreach ($menus as $menu) {
                $permModel->insert([
                    'admin_id' => $adminId,
                    'menu_key' => $menu,
                    'can_view' => 1
                ]);
            }
        }

        return redirect()->to('/admin/admins')->with('success', 'Admin Created');
    }

    public function edit($id)
    {
        $adminModel = new Admins();
        $permModel = new AdminPermissionModel();

        $config = config('Menu');

        $data['admin'] = $adminModel->find($id);
        $data['menus'] = $config->menus;

        $permissions = $permModel->where('admin_id', $id)->findAll();
        $data['assignedMenus'] = array_column($permissions, 'menu_key');

        return view('admin/AdminControl/edit', $data);
    }

public function update($id)
{
    $adminModel = new Admins();
    $permModel = new AdminPermissionModel();

    $admin = $adminModel->find($id);

    // 🛑 Optional safety: prevent editing super admin role
    if ($admin['role'] === 'super_admin') {
        return redirect()->back()->with('error', 'Super Admin role cannot be changed');
    }

    $adminModel->update($id, [
        'name'  => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'role'  => $this->request->getPost('role'), 
    ]);

    $permModel->where('admin_id', $id)->delete();

    $menus = $this->request->getPost('menus');

    if ($menus) {
        foreach ($menus as $menu) {
            $permModel->insert([
                'admin_id' => $id,
                'menu_key' => $menu,
                'can_view' => 1
            ]);
        }
    }

    return redirect()->to('/admin/list-admin')->with('success', 'Updated Successfully');
}



}