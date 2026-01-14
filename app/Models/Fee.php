<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'type',
        'amount',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
