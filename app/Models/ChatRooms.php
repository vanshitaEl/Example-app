<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRooms extends Model
{
    use HasFactory;
    protected $fillable = ['f_user' , 's_user'];

    public function messages(){
        return $this->hasMany(Message::class, 'chat_room_id');
    } 
}
