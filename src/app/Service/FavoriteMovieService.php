<?php

namespace App\Service;
use App\Models\FavoriteMovie;

class FavoriteMovieService
{


    public function addFavoriteMovie($tmdbId)
    {

        $favoriteMovie = FavoriteMovie::updateOrCreate(
            ['tmdb_id' => $tmdbId],
            [
                'title' => '',
                'original_title' => '',
                'release_date' => '',
                'overview' => '',
                'genre_ids' => '',
                'poster_path' => '',
            ]
        );

        return [
            'status_code' => 200,
            'message' => 'Filme adicionado aos favoritos com sucesso',
            'data' => $favoriteMovie,
        ];
    }
}
