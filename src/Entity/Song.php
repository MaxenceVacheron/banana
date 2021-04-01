<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 */
class Song
{



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artist;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToMany(targetEntity=Mood::class, inversedBy="songs")
     */
    private $mood;

    public function __construct()
    {
        $this->mood = new ArrayCollection();
    }


    // public function __toString()
    // {
    //     return $this->getTitle();
    //     // return $this->artist;
    //     // return $this->year;
    //     // return $this->path;
    // }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection|Mood[]
     */
    public function getMood(): Collection
    {
        return $this->mood;
    }

    public function addMood(Mood $mood): self
    {
        if (!$this->mood->contains($mood)) {
            $this->mood[] = $mood;
        }

        return $this;
    }

    public function removeMood(Mood $mood): self
    {
        $this->mood->removeElement($mood);

        return $this;
    }
}
