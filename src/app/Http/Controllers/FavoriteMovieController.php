<?php

namespace App\Http\Controllers;

use App\Service\FavoriteMovieService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class FavoriteMovieController extends Controller
{
    protected FavoriteMovieService $favoriteMovieService;

    /**
     * Construtor para injetar a dependência da FavoriteMovieService.
     *
     * @param FavoriteMovieService $favoriteMovieService
     */
    public function __construct(FavoriteMovieService $favoriteMovieService)
    {
        $this->favoriteMovieService = $favoriteMovieService;
    }

    /**
     * Adiciona um novo filme à lista de favoritos.
     * Recebe todos os dados do filme do frontend.
     *
     * HTTP Method: POST
     * Endpoint: /api/favorites
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Adicionar lógica:
        //Antes de mandar os filmes para o frontEnd, preciso realizar uma verificação se o filme é um filme favorito.
        try {
            $validatedData = $request->validate([
                'tmdb_id'        => 'required|integer|min:1',
                'title'          => 'required|string',
                'original_title' => 'nullable|string',
                'release_date'   => 'nullable|date',
                'overview'       => 'nullable|string',
                'genre_ids'      => 'nullable|array',
                'genre_ids.*'    => 'integer',
                'poster_path'    => 'nullable|string',
                'rating'         => 'nullable|integer|min:0|max:10',
            ]);

            // Converte o array de dados validados em um objeto,
            // pois o método `CreateFavoriteMovie` da Service espera um objeto.
            $movieObject = (object) $validatedData;

            $result = $this->favoriteMovieService->CreateFavoriteMovie($movieObject);

            return response()->json([
                'message' => $result['message'],
                'data' => $result['data']
            ], $result['status_code']);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação dos dados fornecidos.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro inesperado ao adicionar filme favorito.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lista todos os filmes favoritos.
     *
     * HTTP Method: GET
     * Endpoint: /api/favorites
     *
     * @param Request $request // Mantido para compatibilidade, mas não usado diretamente para filtro aqui.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $result = $this->favoriteMovieService->GetFavoriteMovies();
            return response()->json([
                'message' => $result['message'],
                'data' => $result['data']
            ], $result['status_code']);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro inesperado ao listar filmes favoritos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Atualiza a avaliação (rating) de um filme favorito existente.
     *
     * HTTP Method: PUT / PATCH
     * Endpoint: /api/favorites/{id} (onde {id} é o ID primário da sua tabela local)
     *
     * @param Request $request
     * @param int $id O ID primário (da sua base de dados local) do filme favorito a ser atualizado.
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try {
            $validatedData = $request->validate([
                'rating' => 'nullable|integer|min:0|max:10',
            ]);

            $result = $this->favoriteMovieService->UpdateFavoriteMovie($id, $validatedData['rating'] ?? null);

            return response()->json([
                'message' => $result['message'],
                'data' => $result['data']
            ], $result['status_code']);

        } catch (ValidationException $e) {
            // Se a validação falhar, retorna um erro 422
            return response()->json([
                'message' => 'Erro de validação dos dados fornecidos.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e retorna um erro 500
            return response()->json([
                'message' => 'Ocorreu um erro inesperado ao atualizar filme favorito.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove um filme da lista de favoritos.
     *
     * HTTP Method: DELETE
     * Endpoint: /api/favorites/{id} (onde {id} é o ID primário da sua tabela local)
     *
     * @param int $id O ID primário (da sua base de dados local) do filme favorito a ser removido.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            // Chama o método da Service para remover o filme favorito.
            $result = $this->favoriteMovieService->DeleteFavoriteMovie($id);

            // Retorna a resposta JSON com o status code e dados/mensagem da Service.
            return response()->json([
                'message' => $result['message'],
                'data' => $result['data']
            ], $result['status_code']);

        } catch (Exception $e) {
            // Captura qualquer outra exceção inesperada e retorna um erro 500
            return response()->json([
                'message' => 'Ocorreu um erro inesperado ao remover filme favorito.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
