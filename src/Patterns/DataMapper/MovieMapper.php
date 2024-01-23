<?php

declare(strict_types=1);

namespace App\Patterns\DataMapper;

use App\Patterns\BaseMovie;
use PDO;

class MovieMapper extends BaseMovie
{
    private array $identityMap = [];

    public function findById(int $movieId): Movie
    {
        if (isset($this->identityMap[$movieId])) {
            return $this->identityMap[$movieId];
        }

        $this->selectOneStatement->execute([$movieId]);

        $result = $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);

        $movie = new Movie(
            $result['movie_id'],
            $result['genre_id'],
            $result['title'],
            $result['duration'],
            $result['rating']
        );

        $this->identityMap[$movieId] = $movie;

        return $movie;
    }

    public function getAllMovies(): array
    {
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $movies = [];

        foreach ($result as $value) {
            $movies[] = new Movie($value['movie_id'], $value['genre_id'], $value['title'], $value['duration'], $value['rating']);
        }

        return $movies;
    }

    public function insert(array $rawMovieData): Movie
    {
        $this->insertStatement->execute([
            $rawMovieData['genre_id'],
            $rawMovieData['genre_id'],
            $rawMovieData['title'],
            $rawMovieData['duration'],
            $rawMovieData['rating']
        ]);

        $movieId = (int)$this->pdo->lastInsertId();

        $movie = new Movie(
            $movieId,
            $rawMovieData['genre_id'],
            $rawMovieData['title'],
            $rawMovieData['duration'],
            $rawMovieData['rating']
        );

        $this->identityMap[$movieId] = $movie;

        return $movie;
    }

    public function update(Movie $movie): bool
    {
        $this->identityMap[$movie->getMovieId()] = $movie;

        return $this->updateStatement->execute([
            $movie->getGenreId(),
            $movie->getTitle(),
            $movie->getDuration(),
            $movie->getRating(),
            $movie->getMovieId()
        ]);
    }

    public function delete(Movie $movie): bool
    {
        unset($this->identityMap[$movie->getMovieId()]);

        return $this->deleteStatement->execute([$movie->getMovieId()]);
    }
}
