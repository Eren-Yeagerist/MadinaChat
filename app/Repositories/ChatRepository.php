<?php

namespace App\Repositories;

use App\Models\ChatSession;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Rating;
use App\Models\User;

use App\Http\Requests\ChatRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\MessageRequest;

use App\Events\ChatEvent;
use App\Events\NotificationEvent;

use Illuminate\Support\Facades\DB;

class ChatRepository
{
    public function storeChatSession($request)
    {
        $title = $request->title;
        $ChatSession = ChatSession::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
        ]);

        return $ChatSession;
    }

    public function showChatSession($chat)
    {
        $role = auth()->user()->role();
        $user_id = auth()->user()->id;
        if ($role == 'user' && $user_id != $chat->user_id) {
            return false;
        }

        $messages = Message::where('session_id', $chat->id)->withTrashed()->get();
        $data = [
            'chat' => $chat,
            'messages' => $messages,
        ];
        return $data;
    }

    public function endChatSession($chat)
    {
        if ($chat->user_id == auth()->user()->id) {

            $chat->update([
                'status' => 1,
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function unlockChatSession($slug)
    {
        $chat = ChatSession::where('slug', $slug)->first();
        $update = $chat->update(['status' => 0]);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function sendMessage($request)
    {
        if (auth()->user()->isAllowed()) {
            $role = auth()->user()->role();
            $user_id = auth()->user()->id;

            if ($role == 'user') {
                if ($user_id != $request->user_id || $request->status == 1) {
                    return false;
                }
            }

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
                'session_id' => $request->session_id,
                'slug' => $request->slug,
            ];

            $this->sendNotification($notificationData);
            
            return true;                

        } else {
            return false;
        }  
    }

    public function deleteMessage($id)
    {
        $role = auth()->user()->role();
        $user_id = auth()->user()->id;

        $message = Message::with('chatSession')->find($id);

        if ($role == 'user') {
            if ($user_id != $message->user_id) {
                return false;
            }
        }

        $message->delete();
        return $message->chatSession->slug;
    }

    public function storeRating($request, $slug)
    {
        $chat = ChatSession::find($slug);
        $rating = $request->all();
        $ratingValue = (int)$rating['rate'];
        $user_id = auth()->user()->id; 

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
        
            return true;
        } else {
            return false;
        }
    }

    public function sendNotification($data)
    {
        $sender = auth()->user()->id;
        $senderName = auth()->user()->name;
        $slug = $data['slug'];

        $data = Message::where('session_id', $data['session_id'])
                ->distinct()
                ->get(['user_id']);

        $notificationData = [
            'sender' => $sender,
            'recipient' => 0,
            'message' => "New message from <b>$senderName</b> in chat session <b>$slug</b>",
            'url' => route('chat.chat', $slug),
        ];

        foreach ($data as $value) {
            if ($value->user_id != $sender) {
                $notificationData['recipient'] = $value->user_id;
                Notification::create($notificationData);
                NotificationEvent::dispatch($value->user_id);
            }
        }

        return;
    }

    public function readNotification($recipient)
    {
        $notification = Notification::whereRecipient($recipient)
                        ->update(['status' => 1]);
        return;
    }
}