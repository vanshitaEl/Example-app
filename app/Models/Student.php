<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'std'];
    // protected $table = "students";
    protected $primaryKey = "student_id";


    public function images(){
        return $this->hasMany(Image::class);
    }
}
