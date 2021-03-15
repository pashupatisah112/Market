<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Color;
use App\Company;
use App\ProductType;
use App\SubCategory;
use App\Size;
use App\Tag;

class GetController extends Controller
{
    public function getCategories(Request $request)
    {
        $items=$request->per_page;
        $categories=Category::paginate($items);
        return response()->json($categories);
    }
    public function getColors(Request $request)
    {
        $items=$request->per_page;
        $colors=Color::paginate($items);
        return response()->json($colors);
    }
    public function getSubCategories(Request $request)
    {
        $items=$request->per_page;
        $sub=SubCategory::with('category')->paginate($items);
        return response()->json($sub);
    }
    public function getSizes(Request $request)
    {
        $items=$request->per_page;
        $size=Size::paginate($items);
        return response()->json($size);
    }
    public function getCompanies(Request $request)
    {
        $items=$request->per_page;
        $company=Company::with('subCategory')->paginate($items);
        return response()->json($company);
    }
    public function getTypes(Request $request)
    {
        $items=$request->per_page;
        $type=ProductType::paginate($items);
        return response()->json($type);
    }
    public function getTags(Request $request)
    {
        $items=$request->per_page;
        $tags=Tag::paginate($items);
        return response()->json($tags);
    }
}
