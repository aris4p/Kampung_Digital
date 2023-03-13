<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){

        return view('login.login');
    }

    public function authenticate(Request $r){
       $credentials = $r->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)){
            $r->session()->regenerate();

            return redirect()->intended('/dashboard');
        }
        return back()->with('loginError','Username atau password salah');
    }

    public function logout(Request $r){
        Auth::logout();

        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect('/');


    }
}
