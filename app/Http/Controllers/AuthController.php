<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function validateUser(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('chat.home');
        }

        return redirect()->route('chat.login')->with('danger', 'Username or password not match');
    }

     public function logout()
    {
        Session::flush();
        return redirect(route('chat.login'));
    }
}
