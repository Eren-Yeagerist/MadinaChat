<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'session_id',
        'rating'
    ];

    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}
