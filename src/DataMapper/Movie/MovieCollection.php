<?php

declare(strict_types=1);

namespace App\DataMapper\Movie;

use App\Entities\Movie;

final class MovieCollection
{
    /**
     * @var Movie[]
     */
    private array $movies = [];

    public function add(Movie $movie): void
    {
        $this->movies[] = $movie;
    }

    /**
     * @return Movie[]
     */
    public function getMovies(): array
    {
        return $this->movies;
    }
}
