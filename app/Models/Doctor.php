<?php

namespace App\Models;

use App\Enum\Status;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class Doctor extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    
    protected $guard = 'doctor';

    protected $fillable = [
        'name', 'email', 'password', 'status','google_id'
    ];

    // protected $casts = [
    //     'user_role' => Status::class,
    // ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function verfiyToken()
    {
        return $this->hasOne(verifyUser::class, 'doctor_id');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function chatroom(){
        return $this->hasMany(ChatRooms::class);
    }
}
