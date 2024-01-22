<?php

declare(strict_types=1);

namespace App\Patterns\DataMapper;

class Movie
{
    private int $movieId;
    private int $genreId;
    private string $title;
    private int $duration;
    private int $rating;

    public function __construct(int $movieId, int $genreId, string $title, int $duration, int $rating)
    {
        $this->movieId = $movieId;
        $this->genreId = $genreId;
        $this->title = $title;
        $this->duration = $duration;
        $this->rating = $rating;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
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

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
