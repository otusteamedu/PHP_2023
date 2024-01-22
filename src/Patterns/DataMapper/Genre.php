<?php

declare(strict_types=1);

namespace App\Patterns\DataMapper;

class Genre
{
    private int $genreId;
    private string $title;

    public function __construct(int $genreId, string $title)
    {
        $this->genreId = $genreId;
        $this->title = $title;
    }

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function setGenreId(int $genreId): self
    {
        $this->genreId = $genreId;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
