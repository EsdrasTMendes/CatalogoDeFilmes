<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\TmdbService;

class TestTmdbApi extends Command
{
    // Nome do comando pra rodar via terminal
    protected $signature = 'test:tmdb';

    // Descrição exibida no comando `php artisan list`
    protected $description = 'Faz uma chamada de teste à API do TMDB e imprime os títulos dos filmes.';

    // Método principal chamado quando o comando roda
    public function handle(TmdbService $tmdb)
    {
        $this->info('🔍 Buscando filmes com o termo: batman');

        $result = $tmdb->searchMovies('batman');

        if (is_array($result) && isset($result['results'])) {
            $this->info("🎬 Filmes encontrados:");
            foreach ($result['results'] as $movie) {
                $title = $movie['title'] ?? 'Sem título';
                $releaseDate = $movie['release_date'] ?? 'Data desconhecida';
                $this->line("- {$title} ({$releaseDate})");
            }
        } else {
            $this->error('❌ Nenhum resultado encontrado ou erro na requisição.');
        }

        return 0;
    }
}
