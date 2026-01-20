<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'book_id',
        'student_id',
        'section_id',
        'notes',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
