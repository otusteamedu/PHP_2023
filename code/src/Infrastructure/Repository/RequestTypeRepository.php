<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Repository;

use Art\Code\Domain\Entity\RequestType;
use PDO;
use PDOStatement;

class RequestTypeRepository
{
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(private readonly PDO $pdo)
    {
        $this->selectStmt = $pdo->prepare("select * from request_type where request_type_id = ?");
        $this->insertStmt = $pdo->prepare("insert into request_type (name) values (?)");
        $this->updateStmt = $pdo->prepare("update request_type set name = ? where request_type_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from request_type where request_type_id = ?");
    }

    public function findById($id): RequestType
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $requestType = new RequestType();
        $requestType->setId($result['request_type_id']);
        $requestType->setName($result['name']);

        return $requestType;
    }

    public function insert(RequestType $requestType): int
    {
        $this->insertStmt->execute([$requestType->getName()]);
        $requestType->setId((int)$this->pdo->lastInsertId());

        return $requestType->getId();
    }

    public function update(RequestType $requestType): bool
    {
        return $this->updateStmt->execute([$requestType->getName()]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}