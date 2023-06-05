<?php

namespace Models;

class MoviesCollection
{
    public array $movies = [];

    public static function create(\PDO $pdo, array $array): self
    {
        $collection = new self();
        foreach ($array as $item) {
            $movie = \Models\Movie::getById($pdo, $item['id']);
            $collection->movies[] = $movie;
        }
        return $collection;
    }
}
