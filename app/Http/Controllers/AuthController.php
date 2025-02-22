<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function signup(){
        return view('auth.signup');
    }

    public function register(Request $request){

        $data=$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'   
        ]);

        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);

        Auth::login($user);

        return view('welcome');
    }


    public function signin(){
        return view('auth.signin');
    }

    public function login(Request $request){
        $data=$request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'   
        ]);


        if(!Auth::attempt($data)){
           return back()->withErrors([
               'email'=>'Invalid Credentials'
           ])->withInput($request->only('email'));
        }else{
           return redirect()->intended('/');  
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.signin');
    }
    

}
