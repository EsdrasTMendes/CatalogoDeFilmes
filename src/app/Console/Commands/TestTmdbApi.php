<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\TmdbService;

class TestTmdbApi extends Command
{
    protected $signature = 'test:tmdb';
    protected $description = 'Faz uma chamada de teste à API do TMDB e imprime os títulos dos filmes.';
    public function handle(TmdbService $tmdb)
    {
        $this->info('🔍 Buscando filmes com o termo: vingadores');

        $result = $tmdb->searchMovies('vingadores');

        if (is_array($result)) {
            $this->info("🎬 Filmes encontrados:");
            \var_dump($result);
        } else {
            $this->error('❌ Nenhum resultado encontrado ou erro na requisição.');
        }
        return 0;
    }
}
