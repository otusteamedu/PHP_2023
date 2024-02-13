<?php
declare(strict_types=1);

namespace WorkingCode\Hw13\Repository;

use PDO;
use PDOStatement;
use WorkingCode\Hw13\Component\Collection\ArrayCollection;
use WorkingCode\Hw13\Entity\Builder\FilmBuilder;
use WorkingCode\Hw13\Entity\Film;

class FilmRepository
{
    private PDOStatement $updateStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $removeStatement;
    private PDOStatement $selectByIdStatement;

    public function __construct(
        private readonly PDO         $pdo,
        private readonly FilmBuilder $filmBuilder,
        private readonly IdentityMap $identityMap,
    ) {
        $this->updateStatement     = $this->pdo->prepare("UPDATE film SET name = ?, description = ? WHERE id = ?");
        $this->insertStatement     = $this->pdo->prepare("INSERT INTO film(name,description) VALUES (?,?)");
        $this->removeStatement     = $this->pdo->prepare("DELETE FROM film WHERE id = ?");
        $this->selectByIdStatement = $this->pdo->prepare("SELECT * FROM film WHERE id=?");
    }

    public function update(Film $film): bool
    {
        $result = $this->updateStatement->execute([
            $film->getName(),
            $film->getDescription(),
            $film->getId(),
        ]);

        if ($result) {
            $this->identityMap->add($film);
        }

        return $result;
    }

    public function save(Film $film): bool
    {
        $result = $this->insertStatement->execute([
            $film->getName(),
            $film->getDescription(),
        ]);

        if ($result) {
            $film->setId((int)$this->pdo->lastInsertId());
            $this->identityMap->add($film);
        }

        return $result;
    }

    public function remove(Film $entity): bool
    {
        $result = $this->removeStatement->execute([$entity->getId()]);

        if ($result) {
            $this->identityMap->remove($entity);
            unset($entity);
        }

        return $result;
    }

    public function findById(int $id): ?Film
    {
        $film = $this->identityMap->get(Film::class, $id);

        if (!$film) {
            $this->selectByIdStatement->execute([$id]);
            $result = $this->selectByIdStatement->fetch(PDO::FETCH_ASSOC);
            $film   = $result ? $this->filmBuilder->build($result) : null;
        }

        return $film;
    }

    public function getAll(): ArrayCollection
    {
        $exitsFilmIds = $this->identityMap->getIds(Film::class);

        $sql = $exitsFilmIds
            ? sprintf("SELECT * FROM FILM WHERE id NOT IN (%s)", implode(',', $exitsFilmIds))
            : "SELECT * FROM FILM";

        $filmsSource = $this->pdo->query($sql);

        $films = new ArrayCollection();

        foreach ($this->identityMap->getAll(Film::class) as $film) {
            $films->add($film);
        }

        foreach ($filmsSource as $filmSource) {
            $film = $this->filmBuilder->build($filmSource);
            $films->add($film);
            $this->identityMap->add($film);
        }

        return $films;
    }
}
