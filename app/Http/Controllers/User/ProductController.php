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
        $product=Product::select(['id','title','price','image','product_code'])->limit(6)->get();
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
        $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image','product_code'])->get();
        return response()->json($product);
    }
    public function getSelectedCategory(Request $request)
    {
        $category=Category::where('category_name',$request->category_name)->with('subCategory')->get();
        return response()->json($category);
    }
    public function getProductDetails(Request $request)
    {
        $product=Product::where('product_code',$request->code)->with('photo')->with('color')->with('size')->with('company')->get();
        return response()->json($product);
    }
    
}
