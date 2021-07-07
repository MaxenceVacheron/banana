<?php

namespace App\Entity;

use App\Repository\SongHasArtistRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongHasArtistRepository::class)
 */
class SongHasArtist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Song::class, inversedBy="songHasArtists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $song;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="songHasArtists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity=ArtistType::class, inversedBy="songHasArtists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getArtistType(): ?ArtistType
    {
        return $this->type;
    }

    public function setArtistType(?ArtistType $type): self
    {
        $this->type = $type;

        return $this;
    }

}
