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
        $product=Product::whereIn('id',$ids)->with('photo')->with('cart')->get();
        return response()->json($product);
    }
}
