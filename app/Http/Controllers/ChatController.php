<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\User;

use App\Http\Requests\ChatRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\MessageRequest;

use Facades\App\Repositories\ChatRepository;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chats = ChatSession::latest();
        $role = auth()->user()->role();

        if ($role == 'user') {
            $chats = ChatSession::whereUserId(auth()->user()->id)->latest();
        }

        if (request('keyword')) {
            $chats = $chats->where('title', 'like', '%' . request('keyword') . '%');
        }

        $chats = $chats->get();

        return view('index', compact('chats'));
    }

    public function createSession()
    {
        return view('pages.create_chat_session');
    }

    public function storeChatSession(ChatRequest $request)
    {
        $storeChatSession = ChatRepository::storeChatSession($request);
        if ($storeChatSession) {
            return redirect()->route('chat.home')->with('success', 'Chat session created successfully');
        } else {
            return redirect()->back()->withErrors(['msg' => 'Chat session creation failed']);
        }
    }

    public function showChatSession(ChatSession $chat)
    {
        $showChatSession = ChatRepository::showChatSession($chat);
        if ($showChatSession) {
            $chat = $showChatSession['chat'];
            $messages = $showChatSession['messages'];
            return view('pages.chat', compact(['chat', 'messages']));
        } else {
            return redirect()->route('chat.home')->with('danger', 'You are not allowed to see chat session');
        }
    }

    public function endChatSession(ChatSession $chat)
    {
        $endChatSession = ChatRepository::endChatSession($chat);
        if ($endChatSession) {
            return redirect()->route('chat.home')->with('success', 'Chat session ended successfully');
        } else {
            return redirect()->route('chat.home')->with('error', 'You are not allowed to end this chat session');
        }
    }

    public function unlockChatSession($slug)
    {
        $unlcokChatSession = ChatRepository::unlockChatSession($slug);
        if ($unlcokChatSession) {
            return redirect()->route('chat.chat', $slug)->with('success', 'Chat session unlocked successfully');
        } else {
            return redirect()->route('chat.chat', $slug)->withErrors(['msg' => 'Chat session unlocked successfully']);
        }
    }


    public function sendMessage(MessageRequest $request)
    {
        $sendMessage = ChatRepository::sendMessage($request);
        if (!$sendMessage) {
            return redirect()->route('chat.home')->with('error', 'You are not allowed to send message');
        }
    }

    public function deleteMessage($id)
    {
        $deleteMessage = ChatRepository::deleteMessage($id);
        if ($deleteMessage) {
            return redirect()->route('chat.chat', $deleteMessage)->with('success', 'Message has been deleted');
        } else {
            return redirect()->route('chat.home')->with('danger', 'You are not allowed to delete messages');
        }
    }

    public function ratings()
    {
        $ratings = Rating::latest()->get();
        if (auth()->user()->role() == 'user') {
            $ratings = Rating::whereUserId(auth()->user()->id)
                        ->latest()
                        ->get();
        } 
        return view('pages.ratings', compact('ratings'));
    }

    public function rate(ChatSession $chat)
    {
        return view('pages.rate', compact('chat'));
    }

    public function storeRating(RatingRequest $request, $slug)
    {
        $rating = ChatRepository::storeRating($request, $slug);
        if ($rating) {
            return redirect()->route('chat.ratings')->with('success', 'Rating has been submitted');
        } else {
            return redirect()->route('chat.home')->withErrors(['msg' => 'You are not allowed to rate this chat session']);
        }
    }

    public function notifications()
    {
        $notifications = Notification::with('senderUser')->whereRecipient(auth()->user()->id)->latest()->get();
        return view('pages.notifications', compact('notifications'));
    }

    public function sendNotification($data)
    {
        ChatRepository::sendNotification($data);
    }

    public function readNotification()
    {
        $recipient = auth()->user()->id;
        $readNotification = ChatRepository::readNotification($recipient);
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id);
        return view('pages.profile', compact('user'));
    }

}
