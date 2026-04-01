<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Categories;

class CategoryController extends BaseController
{
    public function index()
    {
        $model = new Categories();

        $categories = $model->findAll();

        return view('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    public function store()
    {
        $model = new Categories();

        $model->save([
            'name' => $this->request->getPost('name'),
            'is_active' => 1
        ]);

        return redirect()->back()->with('msg', 'Category added');
    }

    public function update($id)
    {
        $model = new Categories();

        $model->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->back()->with('msg', 'Category updated');
    }

    public function toggle($id)
    {
        $model = new Categories();
        $cat = $model->find($id);

        $model->update($id, [
            'is_active' => $cat['is_active'] ? 0 : 1
        ]);

        return redirect()->back()->with('msg', 'Status changed');
    }
}