<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteMovieFactory> */
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'original_title',
        'release_date',
        'overview',
        'genre_ids',
        'rating',
        'poster_path',
    ];

    protected $casts = [
        'genre_ids' => 'array',
        'rating' => 'integer',
    ];
}
