<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Mapper;

use App\Application\Contract\TodoMapperInterface;
use App\Application\DTO\CreateTodoRequest;
use App\Domain\Exception\InvalidTodoDescriptionException;
use App\Domain\Model\Todo;
use App\Domain\ValueObject\TodoDescription;
use PDO;
use PDOStatement;

class TodoMapper implements TodoMapperInterface
{
    private PDO $db;

    private PDOStatement $selectStmt;
    private PDOStatement $selectAllStmt;
    private PDOStatement $insertStmt;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $this->selectStmt = $this->db->prepare(
            "select description, is_complete from todo where id = ?"
        );
        $this->selectAllStmt = $this->db->prepare(
            "select * from todo"
        );
        $this->insertStmt = $this->db->prepare(
            "insert into todo (description, is_complete) values (?, ?)"
        );
    }

    /**
     * @param int $id
     * @return Todo
     * @throws InvalidTodoDescriptionException
     */
    public function findById(int $id): Todo
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $todo = $this->selectStmt->fetch();

        return new Todo(
            new TodoDescription($todo['description']),
            $todo['is_complete']
        );
    }

    /**
     * @return array
     * @throws InvalidTodoDescriptionException
     */
    public function findAll(): array
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute();
        $todos = $this->selectStmt->fetch();

        $resArray = [];
        if (count($todos)) {
            foreach ($todos as $todo) {
                $resArray[] = new Todo(
                    new TodoDescription($todo['description']),
                    $todo['is_complete']
                );
            }
        }
        return $resArray;
    }

    /**
     * @param CreateTodoRequest $createTodoRequest
     * @return Todo
     * @throws InvalidTodoDescriptionException
     */
    public function insert(CreateTodoRequest $createTodoRequest): Todo
    {
        $this->insertStmt->execute([$createTodoRequest->description, $createTodoRequest->is_complete]);

        return new Todo(
            new TodoDescription($createTodoRequest->description),
            $createTodoRequest->is_complete
        );
    }
}
