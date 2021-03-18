<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;
use App\Mail\PasswordResetMail;



class AuthController extends Controller
{
    public function verify(Request $request)
    {
        return response()->json(Auth::user());
    }
    public function adminLogin(Request $request){
        $credentials=$request->only('email','password','role_id');
        if(Auth::attempt($credentials)){
                $token=Str::random(80);
                Auth::user()->api_token=$token;
                Auth::user()->save();
                return response()->json(['token'=>$token,'admin'=>Auth::user()],203);
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
                $auth_user=Auth::user();
                return response()->json(['token'=>$token,'auth_user'=>$auth_user],203);
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
    public function sendConfirmEmail(Request $request){
        $this->validate($request,[
            'email'=> 'unique:users,email',
        ]);
        Mail::to($request->email)->send(new ConfirmEmail($request->code));
        return $request->code;
    }
    public function socialLogin(Request $request)
    {
        $users = User::where('email', $request->email)->first();
        if ($users === null) {
            $user=new User;
            $token=Str::random(80);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->api_token=$token;
            $user->role_id=$request->role_id;
            $user->save();
            return response()->json(['token'=>$token,'auth_user'=>$user]);
        } else {
        //     $credentials=$request->only('email');
        //    if(Auth::attempt($credentials)){
                $token=Str::random(80);
                $users->api_token=$token;
                $users->save();
                $auth_user=$users;
                return response()->json(['token'=>$token,'auth_user'=>$auth_user],203);
        
        }
    }
    public function sendPasswordResetCode(Request $request)
    {
            Mail::to($request->email)->send(new PasswordResetMail($request->code));
    }
    public function resetPassword(Request $request){
        $pwd=User::where('email',$request->email)->first();
        $pwd->password=Hash::make($request->newPassword);
        $token=Str::random(80);
        $pwd->api_token=$token;
        $pwd->save();
        return response()->json(['token'=>$token,'auth_user'=>$pwd]);
    }
}
