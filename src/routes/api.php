<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteMovieController;

// --- Rota para Buscar Filmes ---
// Permite que o frontend busque filmes pelo nome na API do TMDB.
// Exemplo de uso no frontend: GET /api/movies/search?query=Batman
Route::get('/movies/search', function (Request $request, \App\Service\TmdbService $tmdbService) {
    $query = $request->input('query');
    if (!$query) {
        return response()->json(['message' => 'O parâmetro "query" é obrigatório.'], 400);
    }
    $result = $tmdbService->searchMovies($query);
    return response()->json($result['data'], $result['status_code']);
});
// Mudar a service para uma controller depois que estiver funcionando corretamente.


// --- Rotas para Gerenciar Filmes Favoritos (CRUD) ---
Route::prefix('favorites')->group(function () {
    // Listar todos os filmes favoritos (Read - Collection)
    Route::get('/', [FavoriteMovieController::class, 'index']);
    // Exemplo de uso no frontend: GET /api/favorites
    Route::post('/', [FavoriteMovieController::class, 'store']);
    // Exemplo de uso no frontend: POST /api/favorites (Create - Collection)

    Route::patch('/{id}', [FavoriteMovieController::class, 'update']);
        // Exemplo: PATCH /api/favorites/123 (Update - Item)
    Route::delete('/{id}', [FavoriteMovieController::class, 'destroy']);
    // Exemplo: DELETE /api/favorites/123 (Delete - Item)

    Route::get('/favoriteMoviesByGenre/{genreId}', [FavoriteMovieController::class, 'getByGenre']);
    // Exemplo: GET /api/favorites/favoriteMovies/ByGenre/28 (Read - Collection by Genre)
});


// --- Rota para Obter Gêneros ---
// Permite que o frontend obtenha a lista de gêneros de filmes do TMDB.
// Exemplo de uso no frontend: GET /api/genres
Route::get('/genres', function (\App\Service\GenreService $genreService) {
    $result = $genreService->getGenres();
    // Retorna os dados dos gêneros, junto com o status HTTP apropriado.
    return response()->json($result['data'], $result['status_code']);
});
