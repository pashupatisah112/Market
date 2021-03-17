<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCart()
    {
        $product=Cart::where('user_id',Auth::id())->with('product:id,title,price,image,product_code')->get();
        $total=DB::table('carts')->where('user_id',Auth::id())->sum('total');
        return response()->json(['product'=>$product,'total'=>$total]);
    }
    public function getCartDetail()
    {
        $product=Cart::where('user_id',Auth::id())->with('product:id,title,price,image,product_code')->with('color')->with('size')->get();
        $total=DB::table('carts')->where('user_id',Auth::id())->sum('total');
        return response()->json(['product'=>$product,'total'=>$total]);
    }
    public function getCartListItem()
    {
        $ids=[];
        $carts=Cart::where('user_id',Auth::id())->with('product')->get();
        foreach($carts as $cart){
            foreach($cart->product as $product){
                array_push($ids,$product->id);
            }
            
        }
        array_unique($ids);
        return response()->json($ids);
    }
    public function addToCart(Request $request)
    {
        $cart=new Cart;
        $cart->user_id=Auth::id();
        $cart->amount=$request->amount;
        $cart->total=$request->total;
        $cart->size_id=$request->size;
        $cart->color_id=$request->color;
        $cart->save();
        $cart->product()->sync($request->product_id);
        $c=Cart::where('id',$cart->id)->with('product:id,title,price,image,product_code')->first();
        return response()->json($c);
    }
    public function removeFromCartlist(Request $request)
    {
        Cart::find($request->cart_id)->delete();
    }
}
