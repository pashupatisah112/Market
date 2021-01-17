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
        $product=Product::limit(4)->get();
        return response()->json($product);
    }
    public function getCategories()
    {
        $category=Category::with('subcategory')->get();
        return response()->json($category);
    }
}
