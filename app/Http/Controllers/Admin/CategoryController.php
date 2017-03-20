<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $title = 'Hello world';
        return view('admin.category.index', compact('title'));
    }

    public function getData()
    {
        $data = Category::all(['id', 'name', 'updated_at'])->toJson();
        return response()->json($data);
    }

    public function delete($id)
    {
        Category::where('id', $id)->update(['del_flg' => 1]);
    }

    public function edit($id = null)
    {
        return view('admin.category.edit', compact('id'));
    }

    public function getRecord($id)
    {
        $data = Category::find($id)->toJson();
        return response()->json($data);
    }
}
