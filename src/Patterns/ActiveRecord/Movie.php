<?php

declare(strict_types=1);

namespace App\Patterns\ActiveRecord;

use App\Patterns\BaseMovie;
use PDO;

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

    public function getOneById(int $movieId): self
    {
        $this->selectOneStatement->execute([$movieId]);

        $result = $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setMovieId($result['movie_id'])
            ->setGenreId($result['genre_id'])
            ->setTitle($result['title'])
            ->setDuration($result['duration'])
            ->setRating($result['rating']);
    }

    public function getAllMovies(): array
    {
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $movies = [];

        foreach ($result as $value) {
            $movies[] = (new self($this->pdo))
                ->setMovieId($value['movie_id'])
                ->setGenreId($value['genre_id'])
                ->setTitle($value['title'])
                ->setDuration($value['duration'])
                ->setRating($value['rating']);
        }

        return $movies;
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

    public function getMostDurationMovie(): self
    {
        $mostDurationMovieStatement = $this->pdo->prepare('SELECT * FROM movies ORDER BY duration DESC LIMIT 1');

        $mostDurationMovieStatement->execute();

        $result = $mostDurationMovieStatement->fetchAll(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setMovieId($result['movie_id'])
            ->setGenreId($result['genre_id'])
            ->setTitle($result['title'])
            ->setDuration($result['duration'])
            ->setRating($result['rating']);
    }
}
