<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductType;
use App\Rating;
use App\SubCategory;
use App\Featured;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $product=Product::where('product_code',$request->code)->with('photo')->with('color')->with('size')->with('company')->first();
        return response()->json($product);
    }
    public function getRatings(Request $request)
    {
         $product=Product::where('product_code',$request->code)->first();
         $avg_rating=DB::table('ratings')->where('product_id',$product->id)->avg('rating');
         $total_rated=DB::table('ratings')->where('product_id',$product->id)->count();
         $rated=DB::table('ratings')->where('product_id',$product->id)->select('rating',DB::raw('count(*) as total'))->groupBy('rating')->orderBy('rating','desc')->get();
         $user_rated=Rating::where('product_id',$product->id)->where('user_id',Auth::id())->select('rating')->first();
        return response()->json(['avg'=>$avg_rating,'rating_count'=>$total_rated,'rated'=>$rated,'user_rated'=>$user_rated]);
        //return $total_rated;
    }
    public function giveRating(Request $request)
    {
        
        $product=Product::where('product_code',$request->code)->first();
         $rating=Rating::where('product_id',$product->id)->where('user_id',Auth::id())->first();
         if($rating==null){
             $rate=new Rating;
            $rate->user_id=Auth::id();
            $rate->product_id=$product->id;
            $rate->rating=$request->rated;
            $rate->save();
            return response()->json(['new_rating'=>$rate]);
         }
         else{
             $rate=Rating::find($rating->id);
             $rate->rating=$request->rated;
             $rate->save();
             return response()->json(['update_rating'=>$rate]);
         }
    }
    public function getComments(Request $request)
    {
        $product=Product::where('product_code',$request->code)->select('id')->first();
        $comment=Comment::where('product_id',$product->id)->with('user:id,name')->get();
        return response()->json($comment);
    }
    public function makeComment(Request $request)
    {
        $product=Product::where('product_code',$request->code)->select('id')->first();
        $comment=new Comment;
        $comment->user_id=Auth::id();
        $comment->product_id=$product->id;
        $comment->comment=$request->comment;
        $comment->save();
        $comm=Comment::where('id',$comment->id)->with('user:id,name')->first();
        return response()->json($comm);
    }
    public function getTags(Request $request)
    {
        $product=Product::where('product_code',$request->code)->select('id')->with('tag')->first();
        return response()->json($product);
    }
    public function getSimilarProducts(Request $request)
    {
        $product=Product::where('product_code',$request->code)->select(['sub_category_id','company_id'])->first();
        $sugg=Product::where('sub_category_id',$product->sub_category_id)->where('company_id',$product->company_id)->select(['id','title','price','image','product_code'])->get();
        return response()->json($sugg);

    }
    public function getCollection()
    {
        $coll=ProductType::where('product_type','Collection')->first();
        $product=Product::where('product_type_id',$coll->id)->select(['id','title','price','image','product_code'])->get();
        return response()->json($product);
    }
    public function getOffers()
    {
        $coll=ProductType::where('product_type','Offered')->first();
        $product=Product::where('product_type_id',$coll->id)->select(['id','title','price','image','product_code'])->get();
        return response()->json($product);
    }
    public function getFeatured()
    {
        $prod=Featured::with('product:id,title,product_code')->get();
        return response()->json($prod);
    }
    public function getTopProducts()
    {
        $ids=[];
        $sales=DB::table('sales')->select('product_id',DB::raw('count(product_id) as total'))->groupBy('product_id')->orderBy('total','desc')->get();
        foreach($sales as $sale){
            array_push($ids,$sale->product_id);
        }
        $product=Product::whereIn('id',$ids)->select(['id','title','price','image','product_code'])->limit(12)->get();
        return response()->json($product);
    }
    public function getTopCategory()
    {
        $ids=[];
        $sub_ids=[];
        $sales=DB::table('sales')->select('product_id',DB::raw('count(product_id) as total'))->groupBy('product_id')->orderBy('total','desc')->get();
        foreach($sales as $sale){
            array_push($ids,$sale->product_id);
        }
        $products=Product::whereIn('id',$ids)->select(['id','sub_category_id'])->get();
        foreach($products as $product)
        {
            if(!in_array($product->sub_category_id,$sub_ids))
            {
                array_push($sub_ids,$product->sub_category_id);
            }
            
        }
        $subcat=SubCategory::whereIn('id',$sub_ids)->select(['id','subCategory_name'])->limit(8)->get();
        return response()->json($subcat);
    }
    public function filterTopCategories(Request $request)
    {
        $ids=[];
        $sales=DB::table('sales')->select('product_id',DB::raw('count(product_id) as total'))->groupBy('product_id')->orderBy('total','desc')->get();
        foreach($sales as $sale){
            array_push($ids,$sale->product_id);
        }
        $product=Product::whereIn('id',$ids)->where('sub_category_id',$request->sub_cat_id)->select(['id','title','price','image','product_code'])->limit(12)->get();
        return response()->json($product);
    }
    public function getProductOffers()
    {
        $type=ProductType::where('product_type','Offered')->first();
        $product=Product::where('product_type_id',$type->id)->select(['id','title','price','image','product_code'])->limit(12)->get();
        return response()->json($product);
    }
}
