<?php

declare(strict_types=1);

namespace App\Patterns\RowGateway;

use App\Patterns\BaseGenre;
use PDO;

class GenreFinder extends BaseGenre
{
    public function findOneById(int $genreId): Genre
    {
        $this->selectOneStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneStatement->execute([$genreId]);

        $result = $this->selectOneStatement->fetch();

        return (new Genre($this->pdo))
            ->setGenreId($result['genre_id'])
            ->setTitle($result['title']);
    }

    public function getAllGenres(): array
    {
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $genres = [];

        foreach ($result as $value) {
            $genres[] = (new Genre($this->pdo))
                ->setGenreId($value['genre_id'])
                ->setTitle($value['title']);
        }

        return $genres;
    }
}
