<?php

namespace App\Entity;

use App\Repository\SongHasArtistAndTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongHasArtistAndTypeRepository::class)]
class SongHasArtistAndType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Song::class, inversedBy: 'songHasArtistAndTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private $song;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'songHasArtistAndTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private $artist;

    #[ORM\ManyToOne(targetEntity: ArtistType::class, inversedBy: 'songHasArtistAndTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private $artistType;

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
        return $this->artistType;
    }

    public function setArtistType(?ArtistType $artistType): self
    {
        $this->artistType = $artistType;

        return $this;
    }
}
