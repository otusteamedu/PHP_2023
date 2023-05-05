<?php

namespace App\Entity;

use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CinemaRepository::class)
 */
class Cinema
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
     * @ORM\OneToMany(targetEntity=Hall::class, mappedBy="cinema")
     */
    private $halls;

    public function __construct()
    {
        $this->halls = new ArrayCollection();
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
     * @return Collection<int, Hall>
     */
    public function getHalls(): Collection
    {
        return $this->halls;
    }

    public function addHall(Hall $hall): self
    {
        if (!$this->halls->contains($hall)) {
            $this->halls[] = $hall;
            $hall->setCinema($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): self
    {
        if ($this->halls->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getCinema() === $this) {
                $hall->setCinema(null);
            }
        }

        return $this;
    }
}
