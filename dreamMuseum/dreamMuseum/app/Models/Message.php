<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'chat_id',
        'message',
        'chatId'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function chat() {
        return $this->belongsTo(Chat::class);
    }
}
