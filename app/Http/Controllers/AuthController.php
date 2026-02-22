<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(){
        return view('auth');
    }
    public function register(Request $request){
        $fields = $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);
        if($user &&  Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']])){
           return redirect()->route('index');
    }
}
    public function login(Request $request){
        $fields = $request->validate([
            'email_login' => 'required|string',
            'password_login' => 'required|string'
        ]);
        if(Auth::attempt(['email' => $fields['email_login'], 'password' => $fields['password_login']])){
           return redirect()->route('index');
        }
        return response([
            'message' => 'Invalid credentials'
        ], 401);
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }
}
