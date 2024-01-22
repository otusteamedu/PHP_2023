<?php

declare(strict_types=1);

namespace App\Patterns\RowGateway;

use App\Patterns\BaseMovie;

class Movie extends BaseMovie
{
    private ?int $movieId = null;
    private ?int $genreId = null;
    private ?string $title = null;
    private ?int $duration = null;
    private ?int $rating = null;

    public function getMovieId(): ?int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    public function getGenreId(): ?int
    {
        return $this->genreId;
    }

    public function setGenreId(?int $genreId): self
    {
        $this->genreId = $genreId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->genreId,
            $this->title,
            $this->duration,
            $this->rating
        ]);

        $this->movieId = (int)$this->pdo->lastInsertId();

        return $this->movieId;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->genreId,
            $this->title,
            $this->duration,
            $this->rating,
            $this->movieId
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStatement->execute([$this->movieId]);

        $this->movieId = null;

        return $result;
    }
}
