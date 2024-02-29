<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = [
        'student_id',
        'image',
    ];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}
