<?php

namespace App\Infrastructure\DataMapper;

use App\Domain\Entity\Status;
use App\Domain\ValueObject\Name;
use App\Infrastructure\Db\Db;
use Exception;
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

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->pdo = Db::getPdo();

        $this->selectStmt = $this->pdo->prepare(
            "select name from status where id = ?"
        );

        $this->insertStmt = $this->pdo->prepare(
            "insert into status (name) values (?)"
        );

        $this->updateStmt = $this->pdo->prepare(
            "update status set name = ? where id = ?"
        );

        $this->deleteStmt = $this->pdo->prepare("delete from status where id = ?");

        $this->findByNameStmt = $this->pdo->prepare("select * from status where name = ?");
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findById(int $id): ?Status
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if ($result === false) {
            return null;
        }

        $status = new Status(new Name($result['name']));
        self::setId($status, $id);

        return $status;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findByName(string $name): ?Status
    {
        $this->findByNameStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->findByNameStmt->execute([$name]);
        $result = $this->findByNameStmt->fetch();

        if ($result === false) {
            return null;
        }

        $status = new Status(new Name($result['name']));
        self::setId($status, $result['id']);

        return $status;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function insert(Status $status): Status
    {
        $this->insertStmt->execute([$status->getName()->getValue()]);

        $id = $this->pdo->lastInsertId();
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
