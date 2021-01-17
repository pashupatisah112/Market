<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;



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
    public function customerLogin(Request $request){
        $credentials=$request->only('email','password');
        $remember_me = $request->has('remember_me') ? true : false;
        if(Auth::attempt($credentials,$remember_me)){
                $token=Str::random(80);
                Auth::user()->api_token=$token;
                Auth::user()->save();
                return response()->json(['token'=>$token,'auth_user'=>Auth::user()],203);
        }
        return response()->json(['status'=>'Email or Password is wrong.'],403);
    }
    public function register(Request $request){
        if(is_null($request->phone)){
            $this->validate($request,[
                'email'=> 'unique:users,email',
            ]);
        }
        if(is_null($request->email)){
            $this->validate($request,[
                'phone'=> 'unique:users,phone'
            ]);
        }
         

        $token=Str::random(80);
        $user=new User;
        $user->name=$request->name;
        $user->password=Hash::make($request->password);
        $user->email=null;
        if($request->email != null){
            $user->email=$request->email;
        }
        $user->phone=null;
        if($request->phone != null){
            $user->phone=$request->phone;
        }
        
        $user->api_token=$token;
        $user->role_id=$request->role_id;
        $user->save();
        return response()->json(['token'=>$token,'auth_user'=>$user]);
    }
}
