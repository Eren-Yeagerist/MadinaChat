<?php

namespace App\Http\Controllers;
use App\Models\ChatSession;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Rating;
use App\Models\User;

use Illuminate\Http\Request;
use App\Events\ChatEvent;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\DB;

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
        return view('pages.create_chat_session');
    }

    public function storeChatSession(Request $request)
    {
        $title = $request->title;
        ChatSession::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
        ]);

        return redirect()->route('chat.home')->with('success', 'Chat session created successfully');
    }

    public function showChatSession(ChatSession $chat)
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

    public function endChatSession(ChatSession $chat)
    {
        if ($chat->user_id == auth()->user()->id) {

            $chat->update([
                'status' => 1,
            ]);

            return redirect()->route('chat.home')->with('success', 'Chat session ended successfully');
        } else {
            return redirect()->route('chat.home')->with('error', 'You are not allowed to end this chat session');
        }
    }

    public function unlockChatSession($slug)
    {
        $chat = ChatSession::where('slug', $slug)->first();
        $chat->update([
            'status' => 0,
        ]);

        return redirect()->route('chat.chat', $chat->slug)->with('success', 'Chat session unlocked successfully');
    }


    public function sendMessage(Request $request)
    {
        if (auth()->user()->isAllowed()) {
            $flag = true;
            $role = auth()->user()->role();
            $user_id = auth()->user()->id;

            if ($role == 'user') {
                if ($user_id != $request->user_id || $request->status == 1) {
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

                $notificationData = [
                    'sender' => $user_id,
                    'receiver' => 3,
                    'message' => "Null",
                    'url' => "NUll"
                ];

                // NotificationEvent::dispatch($notificationData);
                $this->sendNotification($notificationData);
                

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

    public function rate(ChatSession $chat)
    {
        return view('pages.rate', compact('chat'));
    }

    public function storeRating(Request $request, $slug)
    {
        $request->validate([
            'rate' => 'required',
        ]);

        $chat = ChatSession::find($slug);
        $rating = $request->all();
        $ratingValue = (int)$rating['rate'];
        $user_id = auth()->user()->id; 

        if ($ratingValue > 0 && $ratingValue <= 5) {
            if ($user_id == $chat->user_id && $chat->status == 1 && $chat->status_rating == 0) {
                DB::beginTransaction();

                Rating::create([
                    'user_id' => $user_id,
                    'session_id' => $chat->id,
                    'rating' => $ratingValue,
                ]);

                $chat->update([
                    'status_rating' => 1,
                ]);

                DB::commit();
            
                return redirect()->route('chat.ratings')->with('success', 'Rating has been submitted');
            } else {
                return redirect()->route('chat.home')->with('danger', 'You are not allowed to rate this chat session');
            }
        } else {
            return redirect()->route('chat.rate')->with('danger', 'Rating must be between 1 and 5');
        }
    }

    public function notifications()
    {
        return view('pages.notifications');
    }

    public function sendNotification($data)
    {
        Notification::create($data);
        NotificationEvent::dispatch($data);
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        return view('pages.profile', compact('user'));
    }

}
