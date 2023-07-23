<?php

declare(strict_types=1);

namespace Imitronov\Hw13\Component\Mapper;

use Imitronov\Hw13\Component\IdentityMap\IdentityMap;
use Imitronov\Hw13\Component\UnitOfWork\UnitOfWork;
use Imitronov\Hw13\Exception\DatabaseException;
use Imitronov\Hw13\Entity\User;

final class UserMapper
{
    private \PDOStatement $selectStmt;

    private \PDOStatement $insertStmt;

    private \PDOStatement $updateStmt;

    private \PDOStatement $deleteStmt;

    private \PDOStatement $partStmt;

    private array $cache;

    public function __construct(
        private readonly \PDO $pdo,
        private readonly IdentityMap $identityMap,
    ) {
        $this->selectStmt = $this->pdo
            ->prepare('SELECT * FROM users WHERE id = :id');

        $this->insertStmt = $this->pdo
            ->prepare('INSERT INTO users (name, email, passwordHash) VALUES (:name, :email, :passwordHash)');

        $this->updateStmt = $this->pdo
            ->prepare('UPDATE users SET name = :name, email = :email, passwordHash = :passwordHash WHERE id = :id');

        $this->deleteStmt = $this->pdo
            ->prepare('DELETE FROM users WHERE id = :id');

        $this->partStmt = $this->pdo
            ->prepare('SELECT * FROM users ORDER BY id LIMIT :limit OFFSET :offset');
    }

    public function firstById(int $id): ?User
    {
        if ($this->identityMap->has($id)) {
            return $this->identityMap->get($id);
        }

        $this->selectStmt->execute(['id' => $id]);
        $raw = $this->selectStmt->fetch();

        if ($raw) {
            $user = $this->rawToObject($raw);
            $this->identityMap->set($id, $user);
            $this->cache[$id] = $this->rawToObject($raw);

            return $user;
        }

        return null;
    }

    public function part(int $limit, int $offset): array
    {
        $this->partStmt->execute([
            'limit' => $limit,
            'offset' => $offset,
        ]);
        $result = $this->selectStmt->fetchAll();
        $collection = [];

        foreach ($result as $raw) {
            $user = $this->rawToObject($raw);
            $this->identityMap->set($user->getId(), $user);
            $collection[] = $user;
        }

        return $collection;
    }

    /**
     * @throws DatabaseException
     */
    public function insert(User $user): User
    {
        $this->insertStmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'passwordHash' => $user->getPasswordHash(),
        ]);
        $id = (int) $this->pdo->lastInsertId();
        $user = $this->firstById($id);

        if (null === $user) {
            throw new DatabaseException('Could not insert user.');
        }

        return $user;
    }

    /**
     * @throws DatabaseException
     */
    public function update(User $user): User
    {
        $columns = [];
        $values = [];
        $cachedUser = array_key_exists($user->getId(), $this->cache)
            ? $this->cache[$user->getId()]
            : null;

        if (null !== $cachedUser) {
            if ($user->getName() !== $cachedUser->getName()) {
                $columns[] = 'name = :name';
                $values['name'] = $user->getName();
            }

            if ($user->getEmail() !== $cachedUser->getEmail()) {
                $columns[] = 'email = :email';
                $values['email'] = $user->getEmail();
            }

            if ($user->getPasswordHash() !== $cachedUser->getPasswordHash()) {
                $columns[] = 'passwordHash = :passwordHash';
                $values['passwordHash'] = $user->getPasswordHash();
            }

            if (count($values) > 0) {
                $updateStmt = $this->pdo->prepare('UPDATE users SET ' . implode(', ', $columns) . ' WHERE id = :id');
                $updateStmt->execute(array_merge(
                    ['id' => $user->getId()],
                    $values,
                ));
            }
        } else {
            $this->updateStmt->execute([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'passwordHash' => $user->getPasswordHash(),
                'id' => $user->getId(),
            ]);
        }

        $this->identityMap->remove($user->getId());
        $user = $this->firstById($user->getId());

        if (null === $user) {
            throw new DatabaseException('Could not update user.');
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $this->deleteStmt->execute([
            'id' => $user->getId(),
        ]);
        $this->identityMap->remove($user->getId());
    }

    private function rawToObject(array $raw): User
    {
        return new User(
            $raw['id'],
            $raw['name'],
            $raw['email'],
            $raw['passwordHash'],
        );
    }
}
