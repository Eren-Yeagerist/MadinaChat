<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ChatSession extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'status',
        'status_rating'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function status()
    {
        $arr = [
            array("status" => "active", "color" => "text-bg-success"), 
            array("status" => "finished", "color" => "text-bg-primary"), 
        ];
        return $arr[$this->status];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
