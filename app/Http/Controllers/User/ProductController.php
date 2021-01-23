<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function getLatestProducts()
    {
        $product=Product::with('photo')->with('color')->with('size')->limit(4)->get();
        return response()->json($product);
    }
    public function getCategories()
    {
        $category=Category::with('subcategory')->get();
        return response()->json($category);
    }
    public function getQuickViewItem(Request $request){
        $quick=Product::find($request->id)->with('photo')->with('color')->with('size');
        return response()->json($quick);
    }
}
