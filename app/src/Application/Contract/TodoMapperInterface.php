<?php

declare(strict_types=1);

namespace App\Application\Contract;

use App\Application\DTO\CreateTodoRequest;
use App\Domain\Model\Todo;

interface TodoMapperInterface
{
    public function findById(int $id): Todo;

    public function findAll(): array;

    public function insert(CreateTodoRequest $createTodoRequest): Todo;
}
