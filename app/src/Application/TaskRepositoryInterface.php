<?php

declare(strict_types=1);

namespace Root\App\Application;



use Root\App\Domain\DTO\TaskDto;

interface TaskRepositoryInterface
{
    public function findById(string $id): TaskDto;
    /**
     * @return TaskDto[]
     */
    public function findAll(): array;
    public function insert(TaskDto $task): TaskDto;
    public function update(TaskDto $task): TaskDto;
}
