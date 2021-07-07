<?php

namespace App\Entity;

use App\Repository\ArtistTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistTypeRepository::class)
 */
class ArtistType
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=SongHasArtist::class, mappedBy="type")
     */
    private $songHasArtists;

    public function __construct()
    {
        $this->songHasArtists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|SongHasArtist[]
     */
    public function getSongHasArtists(): Collection
    {
        return $this->songHasArtists;
    }

    public function addSongHasArtist(SongHasArtist $songHasArtist): self
    {
        if (!$this->songHasArtists->contains($songHasArtist)) {
            $this->songHasArtists[] = $songHasArtist;
            $songHasArtist->setArtistType($this);
        }

        return $this;
    }

    public function removeSongHasArtist(SongHasArtist $songHasArtist): self
    {
        if ($this->songHasArtists->removeElement($songHasArtist)) {
            // set the owning side to null (unless already changed)
            if ($songHasArtist->getArtistType() === $this) {
                $songHasArtist->setArtistType(null);
            }
        }

        return $this;
    }

}
