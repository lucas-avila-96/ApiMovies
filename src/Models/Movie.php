<?php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="movies")
 */
class Movie implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string")
     */
    private $synopsis;

    /**
     * @ORM\ManyToOne(targetEntity="Director")
     */
    private $director;


    /**
    * @ORM\ManyToOne(targetEntity="Genre", inversedBy="movies")
    * @var Genre
    */
    private $genre;

    public function __construct(
		$data = [
            'title' => '',
            'year' => 0,
            'duration' => 0,
            'synopsis' => ''
        ]
	) {
		$this->title = $data['title'];
        $this->year = $data['year'];
        $this->duration = $data['duration'];
        $this->synopsis = $data['synopsis'];
	}

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getSynopsis()
    {
        return $this->synopsis;
    }

    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getDirector()
    {
        return $this->director;
    }

    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
		$genre->setMovie($this);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'duration' => $this->duration,
            'synopsis' => $this->synopsis,
            'director' => $this->director,
            'genre' => $this->genre
        ];
    }
}
