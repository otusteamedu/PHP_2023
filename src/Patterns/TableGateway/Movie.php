<?php

declare(strict_types=1);

namespace App\Patterns\TableGateway;

use App\Patterns\BaseMovie;
use PDO;

class Movie extends BaseMovie
{
    public function getOneById(int $movieId): array
    {
        $this->selectOneStatement->execute([$movieId]);

        return $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllMovies(): array
    {
        $this->selectAllStatement->execute();

        return $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(int $genreId, string $title, int $duration, int $rating): int
    {
        $this->insertStatement->execute([$genreId, $title, $duration, $rating]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $genreId, string $title, int $duration, int $rating, int $movieId): bool
    {
        return $this->updateStatement->execute([[$genreId, $title, $duration, $rating, $movieId]]);
    }

    public function delete(int $movieId): bool
    {
        return $this->deleteStatement->execute([$movieId]);
    }
}
