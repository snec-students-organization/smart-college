<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'qualification',
        'phone',
        'address',
        'dob',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_teacher_id');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class);
    }
}
