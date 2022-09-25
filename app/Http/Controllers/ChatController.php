<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\User;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index');
    }

    public function chat()
    {
        return view('chat');
    }

    public function ratings()
    {
        return view('ratings');
    }

    public function notifications()
    {
        return view('notifications');
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        // dd($user);
        return view('pages.profile', compact('user'));
    }

}
