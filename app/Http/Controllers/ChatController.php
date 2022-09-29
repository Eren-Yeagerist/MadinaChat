<?php

namespace App\Http\Controllers;
use App\Models\ChatSession;
use App\Models\Message;
use App\Models\Rating;
use App\Models\User;

use Illuminate\Http\Request;
use App\Events\ChatEvent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chats = ChatSession::all();
        $role = auth()->user()->role();

        if ($role == 'user') {
            $chats = ChatSession::whereUserId(auth()->user()->id)->get();
        }

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

    public function showChat(ChatSession $chat)
    {
        $flag = true;
        $role = auth()->user()->role();
        $user_id = auth()->user()->id;
        if ($role == 'user' && $user_id != $chat->user_id) {
            $flag = false;
        }
        
        if ($flag) {
            $messages = Message::where('session_id', $chat->id)->withTrashed()->get();
            return view('pages.chat', compact(['chat', 'messages']));
        } else {
            return redirect()->route('chat.home')->with('danger', 'You are not allowed to see chat session');
        }
    }

    public function sendMessage(Request $request)
    {
        if (auth()->user()->isAllowed()) {
            $flag = true;
            $role = auth()->user()->role();
            $user_id = auth()->user()->id;

            if ($role == 'user') {
                if ($user_id != $request->user_id || $request->status == 2) {
                    $flag = false;
                }
            }

            if ($flag) {
                $request->validate([
                    'user_id' => 'required',
                    'session_id' => 'required',
                    'message' => 'required'
                ]);

                $msg = [
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'role' => $role,
                    'session_id' => $request->session_id,
                    'message' => $request->message,
                    'created_at' => now(),
                ];

                $inserted = Message::create([
                    'user_id' => $msg['user_id'],
                    'session_id' => $msg['session_id'],
                    'message' => $msg['message']
                ]);

                $msg['id'] = $inserted->id;
                ChatEvent::dispatch($msg);
            } else {
                return redirect()->route('chat.home')->with('error', 'You are not allowed to send messages');
            }
        } else {
            return redirect()->route('chat.home')->with('error', 'You are not allowed to send messages');
        }   
    }

    public function deleteMessage($id)
    {
        $flag = true;
        $role = auth()->user()->role();
        $user_id = auth()->user()->id;

        $message = Message::with('chatSession')->find($id);

        if ($role == 'user') {
            if ($user_id != $message->user_id) {
                $flag = false;
            }
        }

        if ($flag) {
            $message->delete();
            return redirect()->route('chat.chat', $message->chatSession->slug)->with('success', 'Message has been deleted');
        } else {
            return redirect()->route('chat.chat', $message->chatSession)->with('danger', 'You are not allowed to delete messages');
        }
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
