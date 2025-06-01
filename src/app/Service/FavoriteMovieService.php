<?php

namespace App\Service;

use App\Models\FavoriteMovie;
use Exception; // Importar a classe de exceção

class FavoriteMovieService
{
    /**
     * Cria ou atualiza um filme favorito no banco de dados local.
     * Os dados do filme são recebidos diretamente do frontend.
     *
     * @param object $movie Objeto contendo os dados do filme (do frontend).
     * @return array Retorna um array com 'status_code', 'message' e 'data' (o filme favorito salvo).
     */
    public function CreateFavoriteMovie(object $movie): array
    {
        try {
            $existingFavorite = FavoriteMovie::where('id', $movie->id)->first();
            if ($existingFavorite) {
                return [
                    'status_code' => 200,
                    'message' => 'Filme já está na lista de favoritos.',
                    'data' => $existingFavorite->toArray(),
                ];
            }

            $favoriteMovie = FavoriteMovie::create([
                'id' => $movie->id,
                'title' => $movie->title,
                'original_title' => $movie->original_title,
                'release_date' => $movie->release_date,
                'overview' => $movie->overview,
                'genre_ids' => $movie->genre_ids ?? [],
                'rating' => $movie->rating ?? null,
                'poster_path' => $movie->poster_path,
            ]);

            return [
                'status_code' => 201,
                'message' => 'Filme adicionado aos favoritos com sucesso!',
                'data' => $favoriteMovie->toArray(),
            ];

        } catch (Exception $e) {
            return [
                'status_code' => 500,
                'message' => 'Erro interno ao adicionar filme aos favoritos: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function GetFavoriteMovies(): array
    {
        try {
            $favoriteMovies = FavoriteMovie::all();

            return [
                'status_code' => 200,
                'message' => 'Lista de filmes favoritos recuperada com sucesso.',
                'data' => $favoriteMovies->toArray(),
            ];
        } catch (Exception $e) {
            return [
                'status_code' => 500,
                'message' => 'Erro interno ao recuperar filmes favoritos: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function DeleteFavoriteMovie(int $id): array
    {
        try {
            $favoriteMovie = FavoriteMovie::where('id', $id)->first();
            if (!$favoriteMovie) {
                return [
                    'status_code' => 404,
                    'message' => 'Filme favorito não encontrado.',
                    'data' => [],
                ];
            }

            $favoriteMovie->delete();

            return [
                'status_code' => 204,
                'message' => 'Filme favorito removido com sucesso.',
            ];
        } catch (Exception $e) {
            return [
                'status_code' => 500,
                'message' => 'Erro interno ao remover filme favorito: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function UpdateFavoriteMovie(int $id, int $rating): array
    {
        try {
            $favoriteMovie = FavoriteMovie::where('id', $id)->first();
            if (!$favoriteMovie) {
                return [
                    'status_code' => 404,
                    'message' => 'Filme favorito não encontrado.',
                    'data' => [],
                ];
            }

            $favoriteMovie->rating = $rating;
            $favoriteMovie->save();

            return [
                'status_code' => 200,
                'message' => 'Filme favorito atualizado com sucesso.',
                'data' => $favoriteMovie->toArray(),
            ];
        } catch (Exception $e) {
            return [
                'status_code' => 500,
                'message' => 'Erro interno ao atualizar filme favorito: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function getFavoriteMoviesByGenre(int $genreId): array
    {
        try {
            $favoriteMovies = FavoriteMovie::whereJsonContains('genre_ids', $genreId)->get();

            if ($favoriteMovies->isEmpty()) {
                return [
                    'status_code' => 404,
                    'message' => 'Nenhum filme favorito encontrado para este gênero.',
                    'data' => [],
                ];
            }

            return [
                'status_code' => 200,
                'message' => 'Filmes favoritos recuperados com sucesso.',
                'data' => $favoriteMovies->toArray(),
            ];
        } catch (Exception $e) {
            return [
                'status_code' => 500,
                'message' => 'Erro interno ao recuperar filmes favoritos por gênero: ' . $e->getMessage(),
                'data' => [],
            ];
        }
    }
}
