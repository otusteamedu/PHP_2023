<?php

declare(strict_types=1);

namespace App\DataMapper\Movie;

use App\DataMapper\DataMapper;
use App\Entities\Movie;
use PDO;
use PDOException;

final class MovieMapper extends DataMapper
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->selectStatement = $connection->prepare(
            "select * from " . self::getTableName() . " where id = ?"
        );
        $this->insertStatement = $connection->prepare(
            "insert into " . self::getTableName() . " (name, description) values (:name, :description)"
        );
        $this->deleteStatement = $connection->prepare(
            "delete from " . self::getTableName() . " where id = ?"
        );
        $this->findAllStatement = $connection->prepare(
            "select * from " . self::getTableName()
        );
    }

    public static function getTableName(): string
    {
        return 'movies';
    }

    /**
     * @throws PDOException
     */
    public function getById(int $id): ?Movie
    {
        if ($entity = $this->identityMap->get(Movie::class, $id)) {
            return $entity;
        }

        $this->selectStatement->execute([$id]);
        if (!$data = $this->selectStatement->fetch(PDO::FETCH_ASSOC)) {
            throw new PDOException('Фильм не найден.');
        }

        $entity = new Movie(
            $id,
            $data['name'],
            $data['description']
        );

        $this->identityMap->add($entity);

        return $entity;
    }

    /**
     * @throws PDOException
     */
    public function findAll(): MovieCollection
    {
        $this->findAllStatement->execute();
        if (!$data = $this->findAllStatement->fetchAll(PDO::FETCH_ASSOC)) {
            throw new PDOException('Фильмы не найдены.');
        }

        $collection = new MovieCollection();
        foreach ($data as $row) {
            $collection->add(new Movie(
                $row['id'],
                $row['name'],
                $row['description'],
            ));
        }

        return $collection;
    }

    /**
     * @throws PDOException
     */
    public function insert(Movie $movie): void
    {
        $data = [
            'name' => $movie->getName(),
            'description' => $movie->getDescription()
        ];
        if ($this->insertStatement->execute($data) === false) {
            throw new PDOException('Не удалось добавить фильм.');
        }

        $movie->setId((int) $this->pdo->lastInsertId());
        $this->identityMap->add($movie);
    }

    /**
     * @throws PDOException
     */
    public function update(Movie $movie, array $fields): void
    {
        if (empty($fields)) {
            return;
        }

        $updates = [];
        foreach (array_keys($fields) as $name) {
            $updates[] = "$name = :$name";
        }

        $query = "update " . self::getTableName() . " set " . implode(', ', $updates) . ' where id = :id';
        if ($this->pdo->prepare($query)->execute(['id' => $movie->getId(), ...$fields]) === false) {
            throw new PDOException('Не удалось обновить фильм.');
        }

        $this->identityMap->add($movie);
    }

    /**
     * @throws PDOException
     */
    public function delete(Movie $movie): void
    {
        if ($this->deleteStatement->execute([$movie->getId()]) === false) {
            throw new PDOException('Не удалось удалить фильм.');
        }

        $this->identityMap->remove($movie);
    }
}
