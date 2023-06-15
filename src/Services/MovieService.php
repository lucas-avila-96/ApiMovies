<?php
namespace App\Services;

use App\Models\Movie;
use App\Models\Genre;


class MovieService
{
	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}


public function create($movieData = [
    "title" => "",
    "year" => 0,
    "duration" => 0,
    "synopsis" => ""
])
{

    $movieInfo = [
        'title' => $movieData['title'],
        'year' => $movieData['year'],
        'duration' => $movieData['duration'],
        'synopsis' => $movieData['synopsis']
    ];

    $newMovie = new Movie($movieInfo);
    $this->entityManager->persist($newMovie);
	$this->addGenre($newMovie, $movieData['genreId']);
    $this->entityManager->flush();

    return $newMovie;
}

public function updateMovie($movieId, $movieData) {
    $movie = $this->getMovie($movieId);
    if (!$movie) {
        // Lanza una excepción, devuelve un mensaje de error o realiza cualquier otra acción que consideres apropiada
        throw new \Exception('Movie not found.');
    }

    $movie->setTitle($movieData['title']);
    $movie->setYear($movieData['year']);
    $movie->setDuration($movieData['duration']);
    $movie->setSynopsis($movieData['synopsis']);
    $this->addGenre($movie, $movieData['genreId']);

    $this->entityManager->persist($movie);
    $this->entityManager->flush();

    return $movie;
}


public function delete($movieId)
	{
		$response = [];

		$movie = $this->getMovie($movieId);
		if (!$movie) {
			$response['success'] = false;
			$response['message'] = 'Movie ' . $movieId . ' not found.';
			return $response;
		}

		$this->entityManager->remove($movie);
		$this->entityManager->flush();
		$response = [
			'success' => true,
			'message' => 'Movie deleted successfully',
			'data' => [
				'id' => $movieId
			]
		];
		return $response;
	}

    public function getMovie($id)
	{
		$movieRepository = $this->entityManager->getRepository(Movie::class);
		$movie = $movieRepository->find($id);
		return $movie;
	}

	public function getMovies()
	{
		$movieRepository = $this->entityManager->getRepository(Movie::class);
		$movies = $movieRepository->findAll();
		return $movies;
	}


public function deleteMovie($movieId)
{
    $movie = $this->getMovie($movieId);
    if (!$movie) {
        // Lanza una excepción, devuelve un mensaje de error o realiza cualquier otra acción que consideres apropiada
        throw new \Exception('Movie not found.');
    }

    $this->entityManager->remove($movie);
    $this->entityManager->flush();
}


	public function query($pageNumber = 1, $pageSize = 10)
	{
		$offset = ($pageNumber - 1) * $pageSize;
		$dql = "SELECT u FROM App\Models\User u ORDER BY u.name";
		$query = $this->entityManager->createQuery($dql)
			->setFirstResult($offset)
			->setMaxResults($pageSize);
		$users = $query->getResult();
		return $users;
	}

	public function addGenre($movie, $genreId)
	{
		$genre = $this->entityManager->getRepository(Genre::class)->findOneBy(
			['id' => $genreId]
		);
		if ($genre) {
			$movie->setGenre($genre);
		}
	}
}