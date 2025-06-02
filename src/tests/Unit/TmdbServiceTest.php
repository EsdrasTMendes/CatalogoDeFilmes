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


    /**
     * @test
     */

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
