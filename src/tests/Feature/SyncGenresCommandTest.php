<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\Genre;

class SyncGenresCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_syncs_genres_successfully_from_tmdb_api()
    {
        Http::fake([
            'api.themoviedb.org/3/genre/movie/list*' => Http::response([
                'genres' => [
                    ['id' => 28, 'name' => 'Ação'],
                    ['id' => 12, 'name' => 'Aventura'],
                    ['id' => 80, 'name' => 'Crime'],
                ],
            ], 200),
        ]);

        // 2. Chama o comando Artisan
        $this->artisan('db:genres')
            ->assertExitCode(0)
            ->expectsOutput('Salvando as informações dos gêneros de filmes com a API do TMDB no banco de dados local.')
            ->expectsOutput("Gênero 'Ação' (ID: '28' adicionado com sucesso.")
            ->expectsOutput("Gênero 'Aventura' (ID: '12' adicionado com sucesso.")
            ->expectsOutput("Gênero 'Crime' (ID: '80' adicionado com sucesso.")
            ->expectsOutput('Gêneros adicionados com sucesso!');

        $this->assertDatabaseHas('genres', ['id' => 28, 'name' => 'Ação']);
        $this->assertDatabaseHas('genres', ['id' => 12, 'name' => 'Aventura']);
        $this->assertDatabaseHas('genres', ['id' => 80, 'name' => 'Crime']);
        $this->assertCount(3, Genre::all());
    }

    /** @test */
    public function it_handles_api_errors_during_genre_sync()
    {
        Http::fake([
            'api.themoviedb.org/3/genre/movie/list*' => Http::response([
                'success' => false,
                'status_code' => 401,
                'status_message' => 'Invalid API key.'
            ], 401),
        ]);

        $this->artisan('db:genres')
            ->assertExitCode(1)
            ->expectsOutput('Erro ao adicionar os gêneros!')
            ->expectsOutput('Mensagem de erro: Erro ao obter gêneros de filmes: {"success":false,"status_code":401,"status_message":"Invalid API key."}');

        $this->assertDatabaseCount('genres', 0);
    }

    /** @test */
    public function it_handles_empty_genre_list_from_api()
    {
        Http::fake([
            'api.themoviedb.org/3/genre/movie/list*' => Http::response([
                'genres' => [],
            ], 200),
        ]);

        $this->artisan('db:genres')
            ->assertExitCode(0)
            ->expectsOutput('Salvando as informações dos gêneros de filmes com a API do TMDB no banco de dados local.')
            ->expectsOutput('Nenhum gênero encontrado.');

        $this->assertDatabaseCount('genres', 0);
    }
}
