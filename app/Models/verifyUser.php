<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verifyUser extends Model
{
    use HasFactory;
     
    public $table = "verify_users";

    protected $fillable = [
        'doctor_id', 'token',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
