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
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="songs")
     */
    private $artist;

    /**
     * @ORM\ManyToMany(targetEntity=Mood::class, inversedBy="songs")
     */
    private $moods;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class, inversedBy="songs")
     */
    private $albums;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;



    /**
     * @ORM\OneToMany(targetEntity=SongHasArtist::class, mappedBy="song")
     */
    private $songHasArtists;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
        $this->moods = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->collab = new ArrayCollection();
        $this->songHasArtists = new ArrayCollection();
    }

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

    /**
     * @return Collection|Artist[]
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artist->contains($artist)) {
            $this->artist[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->artist->removeElement($artist);

        return $this;
    }

    /**
     * @return Collection|Mood[]
     */
    public function getMoods(): Collection
    {
        return $this->moods;
    }

    public function addMood(Mood $mood): self
    {
        if (!$this->moods->contains($mood)) {
            $this->moods[] = $mood;
        }

        return $this;
    }

    public function removeMood(Mood $mood): self
    {
        $this->moods->removeElement($mood);

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
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        $this->albums->removeElement($album);

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
            $songHasArtist->setSong($this);
        }

        return $this;
    }

    public function removeSongHasArtist(SongHasArtist $songHasArtist): self
    {
        if ($this->songHasArtists->removeElement($songHasArtist)) {
            // set the owning side to null (unless already changed)
            if ($songHasArtist->getSong() === $this) {
                $songHasArtist->setSong(null);
            }
        }

        return $this;
    }

}
