<?php

namespace App\Http\Controllers\Admin;

use App\Featured;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class FeaturedController extends Controller
{
    public function index()
    {
         $featured=Featured::all();
         return response()->json($featured);
    }
    public function store(Request $request)
    {
        $feat=new Featured;
        $feat->preTag=$request->preTag;
        $feat->promoTitle=$request->promoTitle;
        $feat->product_id=$request->product_id;
        $feat->description=$request->description;
        $feat->save();
        return response()->json($feat);
    }
    public function update(Request $request,$id)
    {
        $feat=Featured::find($id);
        $feat->preTag=$request->preTag;
        $feat->promoTitle=$request->promoTitle;
        $feat->product_id=$request->product_id;
        $feat->description=$request->description;
        $feat->save();
        return response()->json($feat);
    }
    public function delete($id)
    {
        Featured::find($id)->delete();
    }
    public function getProductsFeatured()
    {
        $products=Product::select('id','title')->get();
        return response()->json($products);
    }
    public function addFeaturedImage(Request $request)
    {
         $photo=Featured::find($request->id);
         $photo->photo=$request->photo;
         $photo->save();
         return response()->json($photo);
    }
}
