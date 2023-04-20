<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'anons',
        'author',
        'image',
    ];

    public function genres ()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }
}
