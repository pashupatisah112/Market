<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    
    public function addCategory(Request $request)
    {
        $category=new Category;
        $category->category_name=$request->category_name;
        $category->save();
        return response()->json($category);
    }
    public function updateCategory(Request $request, $id)
    {
        $category=Category::find($id);
        $category->category_name=$request->category_name;
        $category->save();
        return response()->json($category);
    }
    public function deleteCategory($id)
    {
        Category::find($id)->delete();
    }
}
