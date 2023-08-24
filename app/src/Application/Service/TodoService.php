<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Contract\TodoMapperInterface;
use App\Application\DTO\CreateTodoRequest;

class TodoService
{
    private TodoMapperInterface $todoMapper;

    public function __construct(TodoMapperInterface $todoMapper)
    {
        $this->todoMapper = $todoMapper;
    }

    public function createTodo(CreateTodoRequest $createTodoRequest): string
    {
        $todo = $this->todoMapper->insert($createTodoRequest);
        return 'Created Todo with id ' . $todo->getId();
    }

    public function getAllTodos(): array
    {
        $todos = $this->todoMapper->findAll();
        return $todos;
    }
}
