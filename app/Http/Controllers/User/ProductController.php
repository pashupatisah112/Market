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
        $product=Product::select(['id','title','price','image'])->limit(4)->get();
        return response()->json($product);
    }
    public function getCategories()
    {
        $category=Category::with('subcategory')->get();
        return response()->json($category);
    }
    public function getQuickViewItem(Request $request){
        $quick=Product::where('id',$request->product_id)->with('color')->with('size')->first();
        return response()->json($quick);
    }
    
}
