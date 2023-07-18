<?php

declare(strict_types=1);

namespace Otus\App\Database;

use Otus\App\Model\User;

final class UserMapper
{
    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    public function __construct(
        private readonly \PDO $pdo,
        private readonly IdentityMap $identityMap,
    ) {
        $this->selectStmt = $pdo->prepare(
            "select name, surname from public.user where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into public.user (name, surname) values (?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update public.user set name = ?, surname = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from public.user where id = ?");
    }

    public function findById(int $id): User
    {
        $user = $this->identityMap->get(User::class, $id);

        if ($user !== null) {
            return $user;
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new User(
            $id,
            $result['name'],
            $result['surname'],
        );
    }

    /**
     * @param array{
     *     name: string,
     *     surname: string
     * } $raw
     */
    public function insert(array $raw): User
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['surname'],
        ]);

        $user = new User(
            (int) $this->pdo->lastInsertId(),
            $raw['name'],
            $raw['surname'],
        );

        $this->identityMap->set($user);

        return $user;
    }

    public function update(User $user): bool
    {
        $this->identityMap->set($user);

        return $this->updateStmt->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        $this->identityMap->remove($user);

        return $this->deleteStmt->execute([$user->getId()]);
    }

    public function refresh(): self
    {
        $this->identityMap->removeAll();

        return $this;
    }
}
