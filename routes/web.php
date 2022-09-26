<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/login', [AuthController::class, 'login'])->name('chat.login');
Route::post('/login', [AuthController::class, 'validateUser'])->name('chat.validate');
Route::get('/logout', [AuthController::class, 'logout'])->name('chat.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('chat.home');
    Route::get('/profile', [ChatController::class, 'profile'])->name('chat.profile');
});

Route::group(['prefix' => 'user', 'as' => 'user.',  'middleware' => ['auth', 'auth-access:user']], function() {
    Route::get('/chat/{chat}', [ChatController::class, 'index'])->name('chat.chat');
    Route::get('/chat', [ChatController::class, 'createSession'])->name('chat.create');
    Route::post('/chat', [ChatController::class, 'storeSession'])->name('chat.store');
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'notifications'])->name('chat.notifications');
});

Route::group(['prefix' => 'staff', 'as' => 'staff.',  'middleware' => ['auth', 'auth-access:staff']], function() {
    Route::get('/chat/{chat}', [ChatController::class, 'index'])->name('chat.chat');
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'notifications'])->name('chat.notifications');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.',  'middleware' => ['auth', 'auth-access:admin']], function() {
    Route::get('/ratings', [ChatController::class, 'ratings'])->name('chat.ratings');
});