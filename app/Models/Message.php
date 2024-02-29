<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'message', 'receiver_id', 'chat_room_id', 'images'];

    public function chatRoom()
    {
        return $this->belongsTo(ChatRooms::class, 'chat_room_id');
    }
}
