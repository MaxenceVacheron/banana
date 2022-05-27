<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $path;

    #[ORM\ManyToMany(targetEntity: Mood::class, inversedBy: 'songs')]
    private $mood;

    #[ORM\OneToMany(mappedBy: 'song', targetEntity: SongHasArtistAndType::class)]
    private $songHasArtistAndTypes;

    public function __construct()
    {
        $this->songHasArtistAndTypes = new ArrayCollection();
        $this->mood = new ArrayCollection();
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
     * @return Collection<int, Mood>
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

    /**
     * @return Collection<int, SongHasArtistAndType>
     */
    public function getSongHasArtistAndTypes(): Collection
    {
        return $this->songHasArtistAndTypes;
    }

    public function addSongHasArtistAndType(SongHasArtistAndType $songHasArtistAndType): self
    {
        if (!$this->songHasArtistAndTypes->contains($songHasArtistAndType)) {
            $this->songHasArtistAndTypes[] = $songHasArtistAndType;
            $songHasArtistAndType->setSong($this);
        }

        return $this;
    }

    public function removeSongHasArtistAndType(SongHasArtistAndType $songHasArtistAndType): self
    {
        if ($this->songHasArtistAndTypes->removeElement($songHasArtistAndType)) {
            // set the owning side to null (unless already changed)
            if ($songHasArtistAndType->getSong() === $this) {
                $songHasArtistAndType->setSong(null);
            }
        }

        return $this;
    }
}
