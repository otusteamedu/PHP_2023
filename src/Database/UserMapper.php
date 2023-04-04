<?php

declare(strict_types=1);

namespace Twent\Hw13\Database;

use PDO;
use PDOStatement;
use Twent\Hw13\Models\User;
use Twent\Hw13\Validation\UserValidator;
use Twent\Hw13\Validation\ValidationType;

final class UserMapper extends BaseMapper
{
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    public function __construct(
        protected ?PDO $connection,
        protected ?IdentityMap $map = new IdentityMap(),
    ) {
        parent::__construct($connection, $map);

        $this->selectStmt = $this->connection->prepare(
            "select id, firstname, lastname, email, password, age from users where id = ?"
        );

        $this->insertStmt = $this->connection->prepare(
            "insert into users (firstname, lastname, email, password, age) values (?, ?, ?, ?, ?)"
        );

        $this->updateStmt = $this->connection->prepare(
            "update users set firstname = ?, lastname = ?, email = ?, password = ?, age = ? where id = ?"
        );

        $this->deleteStmt = $this->connection->prepare("delete from users where id = ?");
    }

    public function find(int $id): User
    {
        if ($this->map->hasId($id)) {
            return $this->map->get($id);
        }

        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if (! $result) {
            throw new \Exception('Пользователь не найден');
        }

        $userDto = UserValidator::validate($result);

        $user = User::fromDto($userDto);

        $this->map->set($id, $user);

        return $user;
    }

    public function insert(array $raw): User
    {
        $dto = UserValidator::validate($raw, ValidationType::Insert);

        $result = $this->insertStmt->execute([
            $dto->firstname,
            $dto->lastname,
            $dto->email,
            $dto->password,
            $dto->age
        ]);

        if (! $result) {
            throw new \Exception('Ошибка вставки записи!');
        }

        $user = User::fromDto($dto);
        $id = intval($this->connection->lastInsertId());

        $user->setId($id);

        $this->map->set($id, $user);

        return $user;
    }

    public function update(User $user): bool
    {
        if (! $this->map->hasObject($user)) {
            throw new \Exception('Пользователь не найден!');
        }

        $this->map->set($user->getId(), $user);

        return $this->updateStmt->execute([
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getAge(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        if (! $this->map->hasObject($user)) {
            throw new \Exception('Пользователь не найден!');
        }

        $result = $this->deleteStmt->execute([$id = $user->getId()]);

        if (! $result) {
            throw new \Exception('Ошибка удаления!');
        }

        $this->map->forgot($id);

        return $result;
    }

    public function __destruct()
    {
        $this->selectStmt->closeCursor();
        $this->insertStmt->closeCursor();
        $this->updateStmt->closeCursor();
        $this->deleteStmt->closeCursor();

        unset($this->map);
        unset($this->connection);
    }
}
