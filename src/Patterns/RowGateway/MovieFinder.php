<?php

declare(strict_types=1);

namespace App\Patterns\RowGateway;

use App\Patterns\BaseMovie;
use PDO;

class MovieFinder extends BaseMovie
{
    public function findOneById(int $movieId): Movie
    {
        $this->selectOneStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneStatement->execute([$movieId]);

        $result = $this->selectOneStatement->fetch();

        return (new Movie($this->pdo))
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
            $movies[] = (new Movie($this->pdo))
                ->setMovieId($value['movie_id'])
                ->setGenreId($value['genre_id'])
                ->setTitle($value['title'])
                ->setDuration($value['duration'])
                ->setRating($value['rating']);
        }

        return $movies;
    }
}
