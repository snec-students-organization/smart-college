<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class_id', 'class_teacher_id'];

    public function class_teacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
