<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\TmdbService;
use App\Models\Genre;

class SyncGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza os gêneros de filmes com a API do TMDB';

    /**
     * Instancia da classe TmdbService
     *
     * @var TmdbService
     */
    protected TmdbService $tmdb;

    /**
     *
     * @param TmdbService $tmdb
     */
    public function __construct(TmdbService $tmdb)
    {
        parent::__construct();
        $this->tmdb = $tmdb;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Salvando as informações dos gêneros de filmes com a API do TMDB no banco de dados local.');

        $response = $this->tmdb->getGenreMovies();

        if ($response['status_code'] === 200) {

            if(empty($response['data'])) {
                $this->info('Nenhum gênero encontrado.');
                return Command::SUCCESS;
            }
            foreach ($response['data'] as $genre) {
                Genre::updateOrCreate(
                    ['id' => $genre['id']],
                    ['name' => $genre['name']]
                );
                $this->line("Gênero '{$genre['name']}' (ID: '{$genre['id']}' adicionado com sucesso.");
            }

            $this->info('Gêneros adicionados com sucesso!');
            return Command::SUCCESS;
        } else {
            $this->error('Erro ao adicionar os gêneros!');
            $this->error('Mensagem de erro: ' . $response['message']);
            return Command::FAILURE;
        }
    }
}
