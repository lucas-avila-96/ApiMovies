<?php
use App\Services\GenreService;

require_once "bootstrap.php";


if (!isset($entityManager)) {
	echo "Entity manager is not set.\n";
	return;
}

$genreService = new GenreService($entityManager);

$initialGenres = json_decode(file_get_contents(__DIR__ . '/genres.json'), true);

foreach ($initialGenres as $genre) {
	$genreService->create($genre);
}


