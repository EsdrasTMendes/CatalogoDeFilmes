<?php

namespace App\Service;
use Illuminate\Support\Facades\Http;


class TmdbService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
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
            'lenguage' => 'pt-BR',
        ]);

        if($response->successful()) {
            return $response->json();
        }

        return "NOT FOUND";
    }
}
