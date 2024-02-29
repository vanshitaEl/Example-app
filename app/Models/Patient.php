<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'contact', 'file','doctor_id'];
    protected $primaryKey = "patient_id";

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function setNameAttribute($value){

        $this->attributes['name']= ucwords($value);
    }

   
    protected $appends = ['file_url'];
    public function getFileUrlAttribute(){
     
        // return $value->append('File')->toArray();
    // return $value->append(['File']) ? asset('storage/file' . '/' . $value):NULL;
    return $this->file ? asset('storage/file' . '/' . $this->file):NULL;
 }
    
}
