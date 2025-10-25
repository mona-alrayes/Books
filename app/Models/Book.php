<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'author',
        'published_date',
        'isbn',
    ];

    protected $dates = [
        'published_at',
    ];
}
