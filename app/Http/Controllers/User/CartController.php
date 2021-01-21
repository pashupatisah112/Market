<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart()
    {
        $carts=Cart::where('user_id',Auth::id())->with('product')->get();
        return response()->json($carts);
    }
}
