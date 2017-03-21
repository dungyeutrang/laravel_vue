<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $title = 'Manage Category';
        return view('admin.category.index', compact('title'));
    }

    public function getData()
    {
        $data = Category::getAllData();
        return response()->json($data);
    }

    public function delete($id)
    {
        $allCategory = Category::all();
        $listParentId = [$id];
        $isFind = true;
        while ($isFind) {
            $isFind = false;
            foreach ($allCategory as $index => $category) {
                if (in_array($category->parent_id, $listParentId)) {
                    array_push($listParentId, $category->id);
                    unset($allCategory[$index]);
                    $isFind = true;
                }
            }
        }
        Category::deleteCategory($listParentId);
    }

    public function edit($id = null)
    {
        return view('admin.category.edit', compact('id'));
    }

    public function getRecord($id)
    {
        $data = Category::find($id)->toArray();
        $listCategory = Category::getListCategory($id);
        $response = array();
        $response['data'] = $data;
        $response['listCategory'] = $listCategory;
        return response()->json($response);
    }

    public function getListCategory()
    {
        $listCategory = Category::getListCategory();
        return response()->json($listCategory);
    }

    public function saveData(Request $request)
    {
        $category = Category::findOrNew($request->get('id'));
        $category->name = $request->get('name');
        $category->del_flg = Category::DEL_OFF;
        $category->parent_id = $request->get('parent_id');
        $category->save();
    }
}
