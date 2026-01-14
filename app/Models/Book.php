<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'book_number',
        'quantity',
        'price',
        'rack_no',
    ];

    public function book_issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}
