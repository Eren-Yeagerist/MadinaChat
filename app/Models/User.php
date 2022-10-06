<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        $arr = ["user", "staff", "admin"];
        return $arr[$this->role];
    }

    public function isAllowed()
    {
        return $this->role != 2;
    }

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function chatSession()
    {
        return $this->hasMany(ChatSession::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
