<?php
namespace App\Services;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Genre;

class GenreService
{
	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function create(
		$data =	[
			"name" => "",
			"id"	 => 0
		]
	) {
		$existingGenre = $this->entityManager->getRepository(Genre::class)->findOneBy([
			"id"	=> $data["id"]
		]);
		if ($existingGenre) {
			return $existingGenre;
		}
		$genre = new Genre($data);
		$this->entityManager->persist($genre);
		$this->entityManager->flush();
		return $genre;
	}

	public function getGenres()
    {
		$genreRepository = $this->entityManager->getRepository(Genre::class);
		$genres = $genreRepository->findAll();
		return $genres;
	}

	public function getGenre($id)
	{
		$genreRepository = $this->entityManager->getRepository(Genre::class);
		$genre = $genreRepository->find($id);
		return $genre;
	}

	public function getMovies()
    {
		$genreRepository = $this->entityManager->getRepository(Genre::class);
		$genre = $genreRepository->find($id);
		$movies = $genre.getMovies();
		return $movies;
	}

}