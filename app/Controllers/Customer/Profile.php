<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\Users;

class Profile extends BaseController
{
    public function index()
    {
        $model = new Users();
        $user = $model->find(session('id'));

        return view('customer/profile', ['user' => $user]);
    }

    public function update()
    {
        $model = new Users();

        $model->update(session('id'), [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ]);

        return redirect()->back()->with('success', 'Profile updated');
    }
}