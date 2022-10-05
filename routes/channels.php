<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Notification;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('notification.{reveicer}', function ($user, Notification $notification) {
    return (int) $user->id === (int) $notification->receiver;
    // return auth()->check();
});
