<?php

declare(strict_types=1);

namespace Chernomordov\App\DataMapper;

use Chernomordov\App\Entity\MoviesTable;
use Chernomordov\App\IdentityMap;
use PDO;
use PDOStatement;

class MoviesDataMapper

{
    private PDOStatement $selectStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;
    private IdentityMap $identityMap;

    public function __construct(private PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare(
            "SELECT id, name, duration, production_year FROM movies WHERE id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO movies (name, duration, production_year) VALUES (?, ?, ?)"
        );
        $this->deleteStmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");

        $this->identityMap = new IdentityMap();
    }

    public function findById(int $id): MoviesTable
    {
        $identityMapMovie = $this->identityMap->get(MoviesTable::class, $id);

        if ($identityMapMovie !== null) {
            return $identityMapMovie;
        }

        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \RuntimeException("Movie with ID $id not found");
        }

        $movie = $this->createMovieInstance($result);
        $this->identityMap->set($movie);

        return $movie;
    }

    public function insert(array $raw): MoviesTable
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['duration'],
            $raw['production_year'],
        ]);

        $movie = $this->createMovieInstance([
            'id' => (int)$this->pdo->lastInsertId(),
            'name' => $raw['name'],
            'duration' => $raw['duration'],
            'production_year' => $raw['production_year'],
        ]);

        $this->identityMap->set($movie);

        return $movie;
    }

    public function update(MoviesTable $movie, array $raws): bool
    {
        if (empty($raws)) {
            return false;
        }

        $placeholders = implode(', ', array_map(fn($key) => "$key = ?", array_keys($raws)));
        $this->updateStmt = $this->pdo->prepare("UPDATE movies SET $placeholders WHERE id = ?");

        $this->identityMap->set($movie);

        $values = array_values($raws);
        $values[] = $movie->getId();

        return $this->updateStmt->execute($values);
    }


    public function delete(MoviesTable $movie): bool
    {
        $this->identityMap->remove($movie);

        if (method_exists($movie, 'getId')) {
            $id = $movie->getId();
            return $this->deleteStmt->execute([$id]);
        } else {
            echo "Object does not have a valid 'getId' method.\n";
            return false;
        }
    }

    public function refresh(): self
    {
        $this->identityMap->reset();

        return $this;
    }

    private function createMovieInstance(array $data): MoviesTable
    {
        return new MoviesTable(
            (int)$data['id'],
            $data['name'],
            $data['duration'],
            $data['production_year']
        );
    }
}
