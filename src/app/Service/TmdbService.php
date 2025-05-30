<?php

namespace App\Service;
use Illuminate\Support\Facades\Http;


class TmdbService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        // Posteriormente mudar os links para o .env
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = 'https://api.themoviedb.org/3';
    }

    public function searchMovies($query)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
        ])->get("{$this->baseUrl}/search/movie", [
            'query' => $query,
            'page' => 1,
            'language' => 'pt-BR',
        ]);

        if($response->successful()) {
            $data = $response->json();
            $dataNormalized = [];
            foreach ($data['results'] as $movie) {
                $dataNormalized[] = [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'genre_ids' => $movie['genre_ids'] ?? [],
                    'original_title' => $movie['original_title'] ?? 'Sem título original',
                    'poster_path' => $movie['poster_path'] ? "https://image.tmdb.org/t/p/w500{$movie['poster_path']}" : 'https://ih1.redbubble.net/image.4905811447.8675/flat,750x,075,f-pad,750x1000,f8f8f8.jpg',
                    'release_date' => $movie['release_date'] ?? 'Data desconhecida',
                    'overview' => $movie['overview'] ?? 'Sem descrição',
                ];
            }
            return [
                'status_code' => 200,
                'total_results' => $dataNormalized ? count($dataNormalized) : 0,
                'message' => count($dataNormalized) > 0 ?  'Filmes encontrados com sucesso' : 'Nenhum filme encontrado com o título informado',
                'data' => $dataNormalized
            ];
        }

        return [
            'status_code' => $response->status(),
            'total_results' => 0,
            'message' => 'Erro ao buscar filmes: ' . $response->body(),
            'data' => []
        ];
    }

    public function getGenreMovies()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
        ])->get("{$this->baseUrl}/genre/movie/list", [
            'language' => 'pt-BR',
        ]);

        if($response->successful()) {
            $data = $response->json();
            return [
                'status_code' => 200,
                'message' => 'Gêneros de filmes obtidos com sucesso',
                'data' => $data['genres'] ?? []
            ];
        }

        return [
            'status_code' => $response->status(),
            'message' => 'Erro ao obter gêneros de filmes: ' . $response->body(),
            'data' => []
        ];
    }
}
