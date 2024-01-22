<?php

declare(strict_types=1);

namespace App\Patterns\RowGateway;

use App\Patterns\BaseGenre;

class Genre extends BaseGenre
{
    private ?int $genreId = null;
    private ?string $title = null;

    public function getGenreId(): ?int
    {
        return $this->genreId;
    }

    public function setGenreId(int $genreId): self
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

    public function insert(string $title): int
    {
        $this->insertStatement->execute([$title]);

        $this->genreId = (int)$this->pdo->lastInsertId();

        return $this->genreId;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->title,
            $this->genreId
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStatement->execute([$this->genreId]);

        $this->genreId = null;

        return $result;
    }
}
