<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\DataMapper;

use PDOStatement;

use VKorabelnikov\Hw16\MusicStreaming\Application\Storage\DataMapper\UserMapperInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Exceptions\TableRowNotFoundException;
use VKorabelnikov\Hw16\MusicStreaming\Domain\Model\User;

class UserMapper implements UserMapperInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    private PDOStatement $selectByIdStatement;
    private PDOStatement $selectByLoginStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectByIdStatement = $this->pdo->prepare(
            "SELECT * FROM straming_service_users WHERE id=:id"
        );

        $this->selectByLoginStatement = $this->pdo->prepare(
            "SELECT * FROM straming_service_users WHERE login=:login"
        );

        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO straming_service_users (login, sha1_password) VALUES (:login, :sha1_password)"
        );

        
        $this->updateStatement = $this->pdo->prepare(
            "UPDATE straming_service_users SET login=:login sha1_password=:sha1_password WHERE id = :id"
        );

        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM straming_service_users WHERE id = :id"
        );
        
    }


    /**
     * @param int $id
     *
     * @return User
     */
    public function findById(int $id): User
    {
        $this->selectByIdStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute(["id" => $id]);
        $row = $this->selectByIdStatement->fetch();

        if(!$row) {
            throw new TableRowNotFoundException("User with id not found");
        }

        return new User(
            $row['id'],
            $row['login'],
            $row['sha1_password']
        );
    }

    public function findByLogin(string $login): User
    {
        $this->selectByLoginStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByLoginStatement->execute(["login" => $login]);
        $row = $this->selectByLoginStatement->fetch();

        if(!$row) {
            throw new TableRowNotFoundException("User with login not found");
        }

        return new User(
            $row['id'],
            $row['login'],
            $row['sha1_password']
        );
    }

    public function insert(User $user): void
    {
        $this->insertStatement->execute(
            [
                "login" => $user->getLogin(),
                "sha1_password" => $user->getPasswordSha1()
            ]
        );

        $user->setId(
            (int) $this->pdo->lastInsertId()
        );
    }

    public function update(User $user): bool
    {
        return $this->updateStatement->execute([
            "id" => $user->getId(),
            "login" => $user->getLogin(),
            "sha1_password" => $user->getPasswordSha1()
        ]);
    }

    /**
     * @param User $track
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $this->deleteStatement->execute(["id" => $user->getId()]);
    }
}
