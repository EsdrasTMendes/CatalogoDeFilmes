<?php
namespace App\Service;
use App\Models\Genre;



class GenreService
{

    public function getGenres()
    {
        // Busca todos os gêneros de filmes do banco de dados.
        $genres = Genre::all();

        // Normaliza os dados dos gêneros para o formato esperado pelo frontend.
        $dataNormalized = $genres->map(function ($genre) {
            return [
                'id' => $genre->id,
                'name' => $genre->name,
            ];
        });

        // Retorna os dados normalizados com status HTTP 200 (OK).
        return [
            'data' => $dataNormalized,
            'status_code' => 200,
        ];
    }
}
