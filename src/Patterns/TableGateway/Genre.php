<?php

declare(strict_types=1);

namespace App\Patterns\TableGateway;

use App\Patterns\BaseGenre;
use PDO;

class Genre extends BaseGenre
{
    public function getOneById(int $id): array
    {
        $this->selectOneStatement->execute([$id]);

        return $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllGenres(): array
    {
        $this->selectAllStatement->execute();

        return $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $title): int
    {
        $this->insertStatement->execute([$title]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $title): bool
    {
        return $this->updateStatement->execute([$title, $id]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStatement->execute([$id]);
    }
}
