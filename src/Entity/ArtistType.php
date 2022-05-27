<?php

namespace App\Entity;

use App\Repository\ArtistTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistTypeRepository::class)]
class ArtistType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'artistType', targetEntity: SongHasArtistAndType::class)]
    private $songHasArtistAndTypes;

    public function __construct()
    {
        $this->songHasArtistAndTypes = new ArrayCollection();
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
            $songHasArtistAndType->setArtistType($this);
        }

        return $this;
    }

    public function removeSongHasArtistAndType(SongHasArtistAndType $songHasArtistAndType): self
    {
        if ($this->songHasArtistAndTypes->removeElement($songHasArtistAndType)) {
            // set the owning side to null (unless already changed)
            if ($songHasArtistAndType->getArtistType() === $this) {
                $songHasArtistAndType->setArtistType(null);
            }
        }

        return $this;
    }
}
