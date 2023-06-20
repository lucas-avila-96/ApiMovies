<?php
namespace App\Models;
use App\Models\Movie;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="genres")
 */
class Genre implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Movie", mappedBy="genre")
     * @var \Doctrine\Common\Collecition\ArrayCollection
     */
    private $movies;


    public function __construct(
		$data = [
			"id"	=> 0,
			"name"	=> ""
		]
	) {
		$this->id = $data["id"];
		$this->name = $data["name"];
        $this->movies = new ArrayCollection;
	}


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMovies()
    {
        return $this->movies;
    }

    public function setMovie($movie)
    {
        $this->movies[] = $movie;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
