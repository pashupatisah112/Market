<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function verify(Request $request)
    {
        return $request->user()->only('name','email','role_id');
    }
    public function adminLogin(Request $request){
        $credentials=$request->only('email','password','role_id');
        if(Auth::attempt($credentials)){
                $token=Str::random(80);
                Auth::user()->api_token=$token;
                Auth::user()->save();
                return response()->json(['token'=>$token],203);
        }
        return response()->json(['status'=>'Email or Password is wrong.'],403);
    }
}
