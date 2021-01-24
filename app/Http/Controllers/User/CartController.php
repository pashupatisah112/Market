<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart()
    {
        $ids=[];
        $carts=Cart::where('user_id',Auth::id())->select('product_id')->get();
        foreach($carts as $cart){
            array_push($ids,$cart->product_id);
        }
        $product=Product::whereIn('id',$ids)->select(['id','title','price','image'])->with('cart')->get();
        return response()->json($product);
    }
    public function getCartListItem()
    {
        $ids=[];
        $carts=Cart::where('user_id',Auth::id())->select('product_id')->get();
        foreach($carts as $cart){
            array_push($ids,$cart->product_id);
        }
        return response()->json($ids);
    }
    public function addToCart(Request $request)
    {
        $cart=new Cart;
        $cart->product_id=$request->product_id;
        $cart->user_id=Auth::id();
        $cart->amount=$request->amount;
        $cart->total=$request->total;
        $cart->size=$request->size;
        $cart->color=$request->color;
        $cart->save();
        $product=Product::where('id',$request->product_id)->select(['id','title','price','image'])->with('cart')->first();
        return response()->json($product);
    }
}
