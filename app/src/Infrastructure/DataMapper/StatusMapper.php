<?php

namespace App\Infrastructure\DataMapper;

use App\Domain\Entity\Status;
use PDO;
use PDOStatement;
use ReflectionException;

class StatusMapper
{
    use SetEntityIdTrait;

    private PDO $pdo;

    private PDOStatement $selectStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $deleteStmt;

    private PDOStatement $findByNameStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select name from status where id = ?"
        );

        $this->insertStmt = $pdo->prepare(
            "insert into status (name) values (?)"
        );

        $this->updateStmt = $pdo->prepare(
            "update status set name = ? where id = ?"
        );

        $this->deleteStmt = $pdo->prepare("delete from status where id = ?");

        $this->findByNameStmt = $pdo->prepare("select * from status where name = ?");
    }

    /**
     * @throws ReflectionException
     */
    public function findById(int $id): Status
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $status = new Status($result['name']);
        self::setId($status, $id);

        return $status;
    }

    /**
     * @throws ReflectionException
     */
    public function findByName(string $name): Status
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$name]);
        $result = $this->selectStmt->fetch();

        $status = new Status($result['name']);
        self::setId($status, $result['id']);

        return $status;
    }

    /**
     * @throws ReflectionException
     */
    public function insert(array $raw): Status
    {
        $this->insertStmt->execute([$raw['name']]);

        $id = $this->pdo->lastInsertId();
        $status = new Status($raw['name']);
        self::setId($status, $id);

        return $status;
    }

    public function update(Status $status): bool
    {
        return $this->updateStmt->execute([
            $status->getName(),
            $status->getId()
        ]);
    }

    public function delete(Status $employee): bool
    {
        return $this->deleteStmt->execute([$employee->getId()]);
    }
}
