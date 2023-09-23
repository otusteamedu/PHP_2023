<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

use App\Music\Domain\Decorator\Track\TrackInterface;

class Track implements TrackInterface
{
    private int $id;
    private string $name;
    private string $author;
    private int $duration;
    private Genre $genre;

    public function __construct(string $name, string $author, int $duration, Genre $genre)
    {
        $this->name = $name;
        $this->author = $author;
        $this->duration = $duration;
        $this->genre = $genre;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;
    }
}
