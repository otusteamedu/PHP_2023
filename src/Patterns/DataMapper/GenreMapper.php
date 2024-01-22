<?php

declare(strict_types=1);

namespace App\Patterns\DataMapper;

use App\Patterns\BaseGenre;
use PDO;

class GenreMapper extends BaseGenre
{
    private array $identityMap = [];

    public function findById(int $id): Genre
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $this->selectOneStatement->execute([$id]);

        $result = $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);

        $genre = new Genre(
            $result['genre_id'],
            $result['title']
        );

        $this->identityMap[$id] = $genre;

        return $genre;
    }

    public function getAllGenres(): array
    {
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $genres = [];

        foreach ($result as $value) {
            $genres[] = new Genre($value['genre_id'], $value['title']);
        }

        return $genres;
    }

    public function insert(array $rawGenreData): Genre
    {
        $this->insertStatement->execute([
            $rawGenreData['title']
        ]);

        return new Genre(
            (int)$this->pdo->lastInsertId(),
            $rawGenreData['title']
        );
    }

    public function update(Genre $genre): bool
    {
        return $this->updateStatement->execute([
            $genre->getTitle(),
            $genre->getGenreId()
        ]);
    }

    public function delete(Genre $genre): bool
    {
        return $this->deleteStatement->execute([$genre->getGenreId()]);
    }
}
