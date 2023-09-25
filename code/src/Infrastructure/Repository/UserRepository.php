<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Repository;

use Art\Code\Domain\Entity\User;
use PDO;
use PDOStatement;

class UserRepository
{
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(private readonly PDO $pdo)
    {
        $this->selectStmt = $pdo->prepare("select * from \"user\" where user_id = ?");
        $this->insertStmt = $pdo->prepare("insert into user (name) values (?)");
        $this->updateStmt = $pdo->prepare("update user set name = ? where user_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from user where user_id = ?");
    }

    public function findById($id): User
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();
        $user = new User();
        $user->setId($result['user_id']);
        $user->setName($result['name']);

        return $user;
    }

    public function insert(User $user): int
    {
        $this->insertStmt->execute([$user->getName()]);
        $user->setId((int)$this->pdo->lastInsertId());

        return $user->getId();
    }

    public function update(User $user): bool
    {
        return $this->updateStmt->execute([$user->getName()]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}