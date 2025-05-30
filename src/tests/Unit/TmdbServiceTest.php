<?php

namespace Tests\Feature\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Service\TmdbService;
use Illuminate\Support\Facades\Http;

class TmdbServiceTest extends TestCase
{
    protected TmdbService $tmdbService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->tmdbService = $this->app->make(TmdbService::class);
    }
    /**
     * @test
     */
    public function it_should_search_movies_by_title(){
        Http::fake(
            [
                'https://api.themoviedb.org/3/search/movie*' => Http::response([
                    'page' => 1,
                    'results' => [
                        [
                            'id' => 1,
                            'title' => 'O dev que queriamos',
                            'genre_ids' => [28, 12],
                            'original_title' => 'Esdras, the best dev in the street',
                            'poster_path' => '/test.jpg',
                            'release_date' => '2023-01-01',
                            'overview' => 'Sem dúvidas, Esdras, é o dev que faltava para integrar o time da KingHost.',
                        ],
                        [
                            'id' => 2,
                            'title' => 'Esdras, o retorno do dev',
                            'genre_ids' => [16, 35],
                            'original_title' => 'The return of Esdras',
                            'poster_path' => '/test2.jpg',
                            'release_date' => '2023-02-01',
                            'overview' => 'Neste segundo filme, Esdras retorna com mais força e vontade de ajudar a KingHost.',
                        ]
                    ],
                    'total_pages' => 1,
                    'total_results' => 2,
                ], 200)
            ]);

            $response = $this->tmdbService->searchMovies('Esdras');

            $this->assertEquals(200, $response['status_code']);
            $this->assertEquals(2, $response['total_results']);
            $this->assertEquals('Filmes encontrados com sucesso', $response['message']);
            $this->assertCount(2, $response['data']);

            // Verifica o primeiro filme
            $this->assertEquals(1, $response['data'][0]['id']);
            $this->assertEquals('O dev que queriamos', $response['data'][0]['title']);
            $this->assertEquals([28, 12], $response['data'][0]['genre_ids']);
            $this->assertEquals('Esdras, the best dev in the street', $response['data'][0]['original_title']);
            $this->assertEquals('https://image.tmdb.org/t/p/w500/test.jpg', $response['data'][0]['poster_path']);
            $this->assertEquals('2023-01-01', $response['data'][0]['release_date']);
            $this->assertEquals('Sem dúvidas, Esdras, é o dev que faltava para integrar o time da KingHost.', $response['data'][0]['overview']);
            // Verifica o segundo filme
            $this->assertEquals(2, $response['data'][1]['id']);
            $this->assertEquals('Esdras, o retorno do dev', $response['data'][1]['title']);
            $this->assertEquals([16, 35], $response['data'][1]['genre_ids']);
            $this->assertEquals('The return of Esdras', $response['data'][1]['original_title']);
            $this->assertEquals('https://image.tmdb.org/t/p/w500/test2.jpg', $response['data'][1]['poster_path']);
            $this->assertEquals('2023-02-01', $response['data'][1]['release_date']);
            $this->assertEquals('Neste segundo filme, Esdras retorna com mais força e vontade de ajudar a KingHost.', $response['data'][1]['overview']);
    }

    /**
     * @test
     */
    public function it_returns_correct_response_when_no_movies_found()
    {
        Http::fake(
            [
                'https://api.themoviedb.org/3/search/movie*' => Http::response([
                    'page' => 1,
                    'results' => [],
                    'total_pages' => 0,
                    'total_results' => 0,
                ], 200)
            ]);

        $response = $this->tmdbService->searchMovies('filme_inexistente');

        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals(0, $response['total_results']);
        $this->assertEquals('Nenhum filme encontrado com o título informado', $response['message']);
        $this->assertEmpty($response['data']);
    }

    /**
     * @test
     */
    public function it_should_return_error_when_api_fails()
    {
        Http::fake(
            [
                'https://api.themoviedb.org/3/search/movie*' => Http::response('Erro ao buscar filmes', 500)
            ]);

        $response = $this->tmdbService->searchMovies('Esdras');

        $this->assertEquals(500, $response['status_code']);
        $this->assertEquals(0, $response['total_results']);
        $this->assertStringContainsString('Erro ao buscar filmes', $response['message']);
        $this->assertEmpty($response['data']);
    }

    /**
     * @test
     */
    public function it_should_return_unauthorized_error()
    {
        Http::fake(
            [
                'https://api.themoviedb.org/3/search/movie*' => Http::response([
                    'success' => false,
                    'status_code' => 401,
                    'status_message' => 'Invalid API key: You must be granted a valid key.',
                ], 401)
            ]);

        $response = $this->tmdbService->searchMovies('Esdras');

        $this->assertEquals(401, $response['status_code']);
        $this->assertEquals(0, $response['total_results']);
        $this->assertStringContainsString('Erro ao buscar filmes:', $response['message']);
        $this->assertStringContainsString('Invalid API key: You must be granted a valid key.', $response['message']);
        $this->assertEmpty($response['data']);
    }

    /**
     * @test
     */
    public function it_should_get_genre_movies(){
        Http::fake(
            [
                'https://api.themoviedb.org/3/genre/movie/list*' => Http::response([
                    'genres' => [
                        ['id' => 28, 'name' => 'Clean Code'],
                        ['id' => 12, 'name' => 'POO'],
                        ['id' => 16, 'name' => 'UnityTests'],
                        ['id' => 35, 'name' => 'Laravel'],
                    ]
                ], 200)
            ]);

        $response = $this->tmdbService->getGenreMovies();

        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Gêneros de filmes obtidos com sucesso', $response['message']);
        $this->assertCount(4, $response['data']);
        $this->assertEquals(28, $response['data'][0]['id']);
        $this->assertEquals('Clean Code', $response['data'][0]['name']);
        $this->assertEquals(12, $response['data'][1]['id']);
        $this->assertEquals('POO', $response['data'][1]['name']);
        $this->assertEquals(16, $response['data'][2]['id']);
        $this->assertEquals('UnityTests', $response['data'][2]['name']);
        $this->assertEquals(35, $response['data'][3]['id']);
        $this->assertEquals('Laravel', $response['data'][3]['name']);
    }

    /**
     * @test
     */
    public function it_handles_api_errors_for_genre_retrieval(){
        Http::fake(
            [
                'https://api.themoviedb.org/3/genre/movie/list*' => Http::response([
                    'success' => false,
                    'status_code' => 404,
                    'status_message' => 'Erro ao buscar gêneros',
                ], 404)
            ]);

        $response = $this->tmdbService->getGenreMovies();

        $this->assertEquals(404, $response['status_code']);
        $this->assertStringContainsString('Erro ao obter gêneros de filmes:', $response['message']);
        $this->assertEmpty($response['data']);
    }
}
