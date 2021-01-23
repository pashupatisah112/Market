<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Wishlist;
use App\Product;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    
    public function addToWishlist(Request $request)
    {
        $wish=new Wishlist;
        $wish->product_id=$request->product_id;
        $wish->user_id=Auth::id();
        $wish->save();
        $wishlist=Product::where('id',$request->product_id)->with('photo')->first();
        return response()->json($wishlist);
    }
    public function removeFromWishlist(Request $request)
    {
        Wishlist::where('product_id',$request->product_id)->where('user_id',Auth::id())->delete();
    }
    public function getWishlist(){
        $ids=[];
         $wishes=Wishlist::where('user_id',Auth::id())->get();
         foreach($wishes as $wish){
             array_push($ids,$wish->product_id);
         }
         
         $product=Product::whereIn('id',$ids)->with('photo')->get();
        return response()->json($product);
    }
    public function getWishlistItem(){
        $ids=[];
        $wishes=Wishlist::where('user_id',Auth::id())->select('product_id')->get();
        foreach($wishes as $wish){
            array_push($ids,$wish->product_id);
        }
        return response()->json($ids);
    }
}
