<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper;

use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Genre;
use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\GenreMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Exceptions\TableRowNotFoundException;
use PDOStatement;

class GenreMapper implements GenreMapperInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    private PDOStatement $selectByIdStatement;
    private PDOStatement $selectByNameStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectByIdStatement = $this->pdo->prepare(
            "SELECT * FROM genre WHERE id=:id"
        );

        $this->selectByNameStatement = $this->pdo->prepare(
            "SELECT * FROM genre WHERE name=:name"
        );

        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO genre (name) VALUES (:name)"
        );

        $this->updateStatement = $this->pdo->prepare(
            "UPDATE genre SET name=:name WHERE id = :id"
        );

        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM genre WHERE id = :id"
        );
    }


    /**
     * @param int $id
     *
     * @return Genre
     */
    public function findById(int $id): Genre
    {
        $this->selectByIdStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute(["id" => $id]);
        $result = $this->selectByIdStatement->fetch();

        if (!$result) {
            throw new TableRowNotFoundException("Genre with id not found");
        }

        return new Genre(
            $result['id'],
            $result['name']
        );
    }

    public function findByName(string $name): Genre
    {
        $this->selectByNameStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByNameStatement->execute(["name" => $name]);
        $result = $this->selectByNameStatement->fetch();

        if (!$result) {
            throw new TableRowNotFoundException("Genre with name not found");
        }

        return new Genre(
            $result['id'],
            $result['name']
        );
    }

    public function insert(Genre $genre): void
    {
        $this->insertStatement->execute(
            [
                "name" => $genre->getName()
            ]
        );

        $genre->setId(
            (int) $this->pdo->lastInsertId()
        );
    }

    public function update(Genre $genre): bool
    {
        return $this->updateStatement->execute([
            "id" => $genre->getId(),
            "name" => $genre->getName()
        ]);
    }

    /**
     * @param Genre $genre
     *
     * @return bool
     */
    public function delete(Genre $genre): bool
    {
        return $this->deleteStatement->execute(["id" => $genre->getId()]);
    }
}
