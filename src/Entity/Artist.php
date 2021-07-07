<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Song::class, mappedBy="artist")
     */
    private $songs;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class, mappedBy="artists")
     */
    private $albums;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity=SongHasArtist::class, mappedBy="artist")
     */
    private $songHasArtists;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->collab_songs = new ArrayCollection();
        $this->songHasArtists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Song[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->addArtist($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->removeElement($song)) {
            $song->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->addArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            $album->removeArtist($this);
        }

        return $this;
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
            $songHasArtist->setArtist($this);
        }

        return $this;
    }

    public function removeSongHasArtist(SongHasArtist $songHasArtist): self
    {
        if ($this->songHasArtists->removeElement($songHasArtist)) {
            // set the owning side to null (unless already changed)
            if ($songHasArtist->getArtist() === $this) {
                $songHasArtist->setArtist(null);
            }
        }

        return $this;
    }
}
