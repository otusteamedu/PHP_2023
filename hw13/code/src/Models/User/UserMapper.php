<?php

namespace Gkarman\Datamaper\Models\User;

use PDO;
use PDOStatement;

class UserMapper
{
    private PDO $pdo;
    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    private PDOStatement $selectAllStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (email, first_name, last_name) VALUES (?, ?, ?)'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );

        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM users'
        );
    }

    public function findById(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();
        return new User($result);
    }

    public function insert(array $rawUserData): User
    {
        $this->insertStatement->execute([
            $rawUserData['email'],
            $rawUserData['first_name'],
            $rawUserData['last_name'],
        ]);
        $rawUserData['id'] = (int)$this->pdo->lastInsertId();

        return new User(
            $rawUserData
        );
    }

    public function update(array $rawUserData): bool
    {
        $id = $rawUserData['id'];
        unset($rawUserData['id']);

        $fieldsForUpdate = '';
        foreach ($rawUserData as $key => $value) {
            $fieldsForUpdate .= "{$key} = ?, ";
        }

        $this->updateStatement =  $this->pdo->prepare("UPDATE users SET {$fieldsForUpdate} WHERE id = {$id}");

        $values = array_values($rawUserData);
        $values[] = $id;
        return $this->updateStatement->execute($values);
    }

    public function delete(User $user): bool
    {
        return $this->deleteStatement->execute([$user->getId()]);
    }

    public function findAll(): UserCollection
    {
        $collection = new UserCollection();
        $this->selectAllStatement->setFetchMode(\PDO::FETCH_DEFAULT);
        $this->selectAllStatement->execute();
        $rawUsersData = $this->selectAllStatement->fetchAll();

        foreach ($rawUsersData as $rawUserData) {
            $collection->add((new User($rawUserData)));
        }

        return $collection;
    }
}
