<?php

declare(strict_types=1);

namespace Khalikovdn\Hw13\DataMapper;

use Khalikovdn\Hw13\Entity\UserTable;
use Khalikovdn\Hw13\IdentityMap;
use PDO;
use PDOStatement;

class UserDataMapper
{
    private PDOStatement $selectStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;
    private IdentityMap $identityMap;

    /**
     * @param PDO $pdo
     */
    public function __construct(private PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare(
            "SELECT id, name, last_name, second_name, gender, birthday FROM user WHERE id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO user (name, last_name, second_name, gender, birthday) VALUES (?, ?, ?)"
        );
        $this->deleteStmt = $pdo->prepare("DELETE FROM user WHERE id = ?");

        $this->identityMap = new IdentityMap();
    }

    /**
     * @param int $id
     * @return UserTable
     */
    public function findById(int $id): UserTable
    {
        $identityMapMovie = $this->identityMap->get(UserTable::class, $id);

        if ($identityMapMovie !== null) {
            return $identityMapMovie;
        }

        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new \RuntimeException("User with ID $id not found");
        }

        $user = $this->createUserInstance($result);
        $this->identityMap->set($user);

        return $user;
    }

    /**
     * @param array $raw
     * @return UserTable
     */
    public function insert(array $raw): UserTable
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['last_name'],
            $raw['second_name'],
            $raw['gender'],
            $raw['birthday']
        ]);

        $user = $this->createUserInstance([
            'id' => (int)$this->pdo->lastInsertId(),
            'name' => $raw['name'],
            'last_name' => $raw['last_name'],
            'second_name' => $raw['second_name'],
            'gender' => $raw['gender'],
            'birthday' => $raw['birthday']
        ]);

        $this->identityMap->set($user);

        return $user;
    }

    /**
     * @param UserTable $user
     * @param array $raws
     * @return bool
     */
    public function update(UserTable $user, array $raws): bool
    {
        if (empty($raws)) {
            return false;
        }

        $placeholders = implode(', ', array_map(fn($key) => "$key = ?", array_keys($raws)));
        $this->updateStmt = $this->pdo->prepare("UPDATE user SET $placeholders WHERE id = ?");

        $this->identityMap->set($user);

        $values = array_values($raws);
        $values[] = $user->getId();

        return $this->updateStmt->execute($values);
    }

    /**
     * @param UserTable $movie
     * @return bool
     */
    public function delete(UserTable $movie): bool
    {
        $this->identityMap->remove($movie);

        if (method_exists($movie, 'getId')) {
            $id = $movie->getId();
            return $this->deleteStmt->execute([$id]);
        } else {
            echo "Object does not have a valid 'getId' method.\n";
            return false;
        }
    }

    /**
     * @return $this
     */
    public function refresh(): self
    {
        $this->identityMap->reset();

        return $this;
    }

    /**
     * @param array $data
     * @return UserTable
     */
    private function createUserInstance(array $data): UserTable
    {
        return new UserTable(
            (int)$data['id'],
            $data['name'],
            $data['last_name'],
            $data['second_name'],
            $data['gender'],
            $data['birthday']
        );
    }
}
