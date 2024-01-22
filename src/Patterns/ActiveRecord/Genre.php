<?php

declare(strict_types=1);

namespace App\Patterns\ActiveRecord;

use App\Patterns\BaseGenre;
use PDO;

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

    public function findOneById(int $genreId): self
    {
        $this->selectOneStatement->execute([$genreId]);

        $result = $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setGenreId($result['genre_id'])
            ->setTitle($result['title']);
    }

    public function getAllGenres(): array
    {
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $genres = [];

        foreach ($result as $value) {
            $genres[] = (new self($this->pdo))
                ->setGenreId($value['genre_id'])
                ->setTitle($value['title']);
        }

        return $genres;
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

    public function getMostGenre(): self
    {
        $mostGenreStatement = $this->pdo->prepare(
            'SELECT
	            count(*) AS count,
	            genres.title,
	            genres.genre_id
            FROM
	            movies
            INNER JOIN genres
            ON
	            movies.genre_id = genres.genre_id
            GROUP BY
	            genres.genre_id
            ORDER BY
	            count DESC
            LIMIT 1');

        $mostGenreStatement->execute();

        $result = $mostGenreStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setGenreId($result['genre_id'])
            ->setTitle($result['title']);
    }
}
