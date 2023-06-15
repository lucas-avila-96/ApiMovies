<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Movie;
use App\Services\MovieService;

class MovieController
{

    private $app;
	private $movieService;
	private $entityManager;

    public function __construct($app, $entityManager)
	{
		$this->app = $app;
		$this->entityManager = $entityManager;
        $this->movieService = new MovieService($entityManager);
	}

    public function buildRoutes()
{
    $this->app->get('/', [$this, 'welcome']);
    $this->app->get('/movies', [$this, 'getAll']);
    $this->app->get('/movies/{id}', [$this, 'getById']);
    $this->app->post('/movies', [$this, 'create']);
    $this->app->put('/movies/{id}', [$this, 'update']);
    $this->app->delete('/movies/{id}', [$this, 'delete']);
}

public function welcome(Request $request, Response $response, $args)
{
    $response->getBody()->write('Welcome to the API');
    return $response;
}

public function getAll(Request $request, Response $response, $args)
	{
		$movieList = json_encode($this->movieService->getMovies(), JSON_PRETTY_PRINT);
		$response->getBody()->write($movieList);
		return $response;
	}

public function getById(Request $request, Response $response, $args)
{
        $movieId = $args['id'];
		$movie = json_encode($this->movieService->getMovie($movieId), JSON_PRETTY_PRINT);
		$response->getBody()->write($movie);
		return $response;
}

public function create(Request $request, Response $response, $args)
{
    {
		$movie = json_decode($request->getBody(), true);
		$movie = json_encode($this->movieService->create($movie), JSON_PRETTY_PRINT);
		$response->getBody()->write($movie);
		return $response;
	}
}

public function update(Request $request, Response $response, $args)
{
    $movieId = $args['id'];
    $movieData = json_decode($request->getBody(), true);
    $updatedMovie = $this->movieService->updateMovie($movieId, $movieData);
    $response->getBody()->write(json_encode($updatedMovie, JSON_PRETTY_PRINT));
    return $response;
}

public function delete(Request $request, Response $response, $args)
{
    $movieId = $args['id'];
    $this->movieService->deleteMovie($movieId);
    return $response->withStatus(204); // No Content
}
}
