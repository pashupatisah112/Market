<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\SubCategory;

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
    public function getProducts(Request $request)
    {
        $sub=SubCategory::where('subCategory_name',$request->subCat)->first();
        $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image'])->get();
        return response()->json($product);
    }
    public function getSelectedCategory(Request $request)
    {
        $category=Category::where('category_name',$request->category_name)->with('subCategory')->get();
        return response()->json($category);
    }
    
}
