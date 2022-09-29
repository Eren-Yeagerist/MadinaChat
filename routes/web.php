<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Events\ChatEvent;

use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/login', [AuthController::class, 'login'])->name('chat.login');
Route::post('/login', [AuthController::class, 'validateUser'])->name('chat.validate');
Route::get('/logout', [AuthController::class, 'logout'])->name('chat.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('chat.home');
    Route::get('/profile', [ChatController::class, 'profile'])->name('chat.profile');
    Route::get('/chat/{chat:slug}', [ChatController::class, 'showChat'])->name('chat.chat');
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{chat:id}/delete', [ChatController::class, 'deleteMessage'])->name('chat.message.delete');
});

Route::group(['prefix' => 'user', 'as' => 'user.',  'middleware' => ['auth', 'auth-access:user']], function() {
    Route::get('/chat', [ChatController::class, 'createSession'])->name('chat.create');
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'notifications'])->name('chat.notifications');
});

Route::group(['prefix' => 'staff', 'as' => 'staff.',  'middleware' => ['auth', 'auth-access:staff']], function() {
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'notifications'])->name('chat.notifications');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.',  'middleware' => ['auth', 'auth-access:admin']], function() {
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
});


    
