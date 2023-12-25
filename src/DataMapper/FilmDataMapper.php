<?php

namespace App\DataMapper;

use App\Entity\Film;
use App\IdentityMap;
use PDO;
use PDOStatement;

class FilmDataMapper
{
    private PDOStatement $selectStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $deleteStmt;

    private IdentityMap $identityMap;

    public function __construct(private readonly PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare(
            "select name, genre, year_of_release, duration from films where id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "insert into films (name, genre, year_of_release, duration) values (?, ?, ?, ?)"
        );
        $this->deleteStmt = $pdo->prepare("delete from films where id = ?");

        $this->identityMap = new IdentityMap();
    }

    public function findById(int $id): ?Film
    {
        $identityMapFilm = $this->identityMap->get(Film::class, $id);

        if ($identityMapFilm !== null) {
            return $identityMapFilm;
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $film = new Film(
            $id,
            $result['name'],
            $result['genre'],
            $result['year_of_release'],
            $result['duration']
        );

        $this->identityMap->set($film);

        return $film;
    }

    public function insert(array $raw): Film
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['genre'],
            $raw['year_of_release'],
            $raw['duration'],
        ]);

        $film = new Film(
            (int) $this->pdo->lastInsertId(),
            $raw['name'],
            $raw['genre'],
            $raw['year_of_release'],
            $raw['duration'],
        );

        $this->identityMap->set($film);

        return $film;
    }

    public function update(Film $film, array $raws): bool
    {
        if (empty($raws)) {
            return false;
        }

        $this->updateStmt = $this->pdo->prepare(
            sprintf('update films set %s where id = ?', implode(', ', array_keys($raws))),
        );

        $this->identityMap->set($film);

        return $this->updateStmt->execute([
            ...array_values($raws),
            $film->getId(),
        ]);
    }

    public function delete(Film $film): bool
    {
        $this->identityMap->remove($film);

        return $this->deleteStmt->execute([$film->getId()]);
    }

    public function refresh(): self
    {
        $this->identityMap->reset();

        return $this;
    }
}
