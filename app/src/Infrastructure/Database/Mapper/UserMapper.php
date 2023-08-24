<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Mapper;

use App\Application\Contract\UserMapperInterface;
use App\Application\DTO\RegisterUserRequest;
use App\Domain\Exception\InvalidLoginException;
use App\Domain\Exception\InvalidPasswordException;
use App\Domain\Model\User;
use App\Domain\ValueObject\Login;
use App\Domain\ValueObject\Password;
use PDO;
use PDOStatement;

class UserMapper implements UserMapperInterface
{
    private PDO $db;

    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $this->selectStmt = $this->db->prepare(
            "select login, password from user where id = ?"
        );
        $this->insertStmt = $this->db->prepare(
            "insert into user (login, password) values (?, ?)"
        );
    }

    /**
     * @param int $id
     * @return User
     * @throws InvalidLoginException
     * @throws InvalidPasswordException
     */
    public function findById(int $id): User
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $user = $this->selectStmt->fetch();

        return new User(
            new Login($user['login']),
            new Password($user['password'])
        );
    }

    /**
     * @param RegisterUserRequest $registerUserRequest
     * @return User
     * @throws InvalidLoginException
     * @throws InvalidPasswordException
     */
    public function insert(RegisterUserRequest $registerUserRequest): User
    {
        $this->insertStmt->execute([$registerUserRequest->login, $registerUserRequest->password]);

        return new User(
            new Login($registerUserRequest->login),
            new Password($registerUserRequest->password)
        );
    }
}
