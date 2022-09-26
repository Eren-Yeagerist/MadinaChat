<?php

namespace App\Http\Controllers;
use App\Models\ChatSession;
use App\Models\Rating;
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
        $chats = ChatSession::whereUserId(auth()->user()->id)->get();
        return view('index', compact('chats'));
    }

    public function createSession()
    {
        return view('pages.create_session');
    }

    public function storeSession(Request $request)
    {
        $title = $request->title;
        ChatSession::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
        ]);

        return redirect()->route('chat.home')->with('success', 'Chat session created successfully');
    }

    public function chat()
    {
        return view('chat');
    }

    public function ratings()
    {
        $ratings = Rating::whereUserId(auth()->user()->id)->get();
        return view('pages.ratings', compact('ratings'));
    }

    public function notifications()
    {
        return view('pages.notifications');
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        return view('pages.profile', compact('user'));
    }

}
