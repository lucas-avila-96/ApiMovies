<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Genre;
use App\Services\GenreService;

class GenreController
{
    private $app;
    private $genreService;
	private $entityManager;

    public function __construct($app, $entityManager)
    {
		$this->entityManager = $entityManager;
        $this->app = $app;
        $this->genreService = new GenreService($entityManager);

    }

    public function buildRoutes()
    {
        $this->app->get('/genres', [$this, 'getAll']);
        $this->app->get('/genres/{id}', [$this, 'getById']);
        $this->app->get('/genres/{id}/all', [$this, 'getAllMovies']);
    }

    public function getAll(Request $request, Response $response, $args)
	{
		$genreList = json_encode($this->genreService->getGenres(), JSON_PRETTY_PRINT);
		$response->getBody()->write($genreList);
		return $response;
	}

    public function getById(Request $request, Response $response, $args)
{
        $genreId = $args['id'];
		$genre = json_encode($this->genreService->getGenre($genreId), JSON_PRETTY_PRINT);
		$response->getBody()->write($genre);
		return $response;
}

public function getAllMovies(Request $request, Response $response, $args)
{
    $genreId = $args['id'];
    $genre = $this->genreService->getGenre($genreId);
    $movies = json_encode($genre->getMovies());
    $response->getBody()->write($movies);
    return $response;
}



}
