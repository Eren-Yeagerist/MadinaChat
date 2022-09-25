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

Route::middleware(['auth', 'auth-access:user'])->group(function () {
    Route::get('/home', [ChatController::class, 'index'])->name('chat.home');
    Route::get('/ratings', [ChatController::class, 'index'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'index'])->name('chat.notifications');
    Route::get('/chat/{chat}', [ChatController::class, 'index'])->name('chat.chat');
    Route::get('/profile', [ChatController::class, 'profile'])->name('chat.profile');
});

Route::middleware(['auth', 'auth-access:staff'])->group(function () {
    Route::get('/home', [ChatController::class, 'index'])->name('chat.home');
    Route::get('/ratings', [ChatController::class, 'index'])->name('chat.ratings');
    Route::get('/notifications', [ChatController::class, 'index'])->name('chat.notifications');
    Route::get('/chat/{chat}', [ChatController::class, 'index'])->name('chat.chat');
    Route::get('/profile', [ChatController::class, 'profile'])->name('chat.profile');
});