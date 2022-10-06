<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Events\ChatEvent;

use Illuminate\Http\Request;

Route::get('/login', [AuthController::class, 'login'])->name('chat.login');
Route::post('/login', [AuthController::class, 'validateUser'])->name('chat.validate');
Route::get('/logout', [AuthController::class, 'logout'])->name('chat.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('chat.home');
    Route::get('/profile', [ChatController::class, 'profile'])->name('chat.profile');
    Route::get('/chat/{chat:slug}', [ChatController::class, 'showChatSession'])->name('chat.chat');
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{chat:slug}/unlock', [ChatController::class, 'unlockChatSession'])->name('chat.chat.unlock');
    Route::get('/chat/{chat:id}/delete', [ChatController::class, 'deleteMessage'])->name('chat.message.delete');
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
    Route::get('hoho/{id}', [ChatController::class, 'sendNotification']);
    Route::get('/notifications', [ChatController::class, 'notifications'])->name('chat.notifications');
});

Route::group(['prefix' => 'user', 'as' => 'user.',  'middleware' => ['auth', 'auth-access:user']], function() {
    Route::get('/chat', [ChatController::class, 'createSession'])->name('chat.create');
    Route::post('/chat/store', [ChatController::class, 'storeChatSession'])->name('chat.store');
    Route::put('/chat/{chat:slug}/end', [ChatController::class, 'endChatSession'])->name('chat.end');
    Route::get('/chat/{chat:slug}/rate', [ChatController::class, 'rate'])->name('chat.rate');
    Route::post('/chat/{chat}/rate', [ChatController::class, 'storeRating'])->name('chat.rate.store');
    
});




    
