<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'photo', 'teacher_id', 'admission_date', 'yearly_fees'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');  // Assuming the 'teacher_id' in 'students' table
    }



    // Relationship with Teacher (1-to-1)
    // public function classTeacher()
    // {
    //     return $this->belongsTo(Teacher::class, 'class_teacher_id');
    // }

    // Relationship with SchoolClass (1-to-1)
    // public function schoolClass()
    // {
    //     return $this->belongsTo(SchoolClass::class, 'class_id');
    // }

}
