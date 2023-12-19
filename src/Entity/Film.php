<?php

declare(strict_types=1);

namespace App\Entity;

class Film
{
    private ?int $id = null;

    private ?string $name = null;

    private ?string $genre = null;

    private ?int $yearOfRelease = null;

    private ?int $duration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getYearOfRelease(): ?int
    {
        return $this->yearOfRelease;
    }

    public function setYearOfRelease(?int $yearOfRelease): self
    {
        $this->yearOfRelease = $yearOfRelease;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
