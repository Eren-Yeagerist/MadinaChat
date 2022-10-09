<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(AuthRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'role' => 0,
        ]);

        return redirect()->route('chat.login')->with('success', 'Registration successful. Please login.');
    }

    public function validateUser(AuthRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('chat.home');
        }

        return redirect()->route('chat.login')->withErrors(['msg' => 'Username or password not match']);
    }

     public function logout()
    {
        Session::flush();
        return redirect(route('chat.login'));
    }
}
