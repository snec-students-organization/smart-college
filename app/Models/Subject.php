<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type', 'class_id'];

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
