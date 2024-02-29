<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class servant extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guard = 'servant';

    protected $fillable = [
        'name', 'email', 'password',
    ];
}
