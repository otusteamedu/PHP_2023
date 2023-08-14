<?php

declare(strict_types=1);

namespace Root\App;

use PDO;
use PDOException;
use Root\App\Data\TaskDto;

class TaskTable
{
    private PDO $pdo;
    private string $table = 'task';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws AppException
     */
    public function findById(string $id): TaskDto
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        $sql = "select * from {$this->table} where id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);
        $result = $statement->fetch();
        if (empty($result)) {
            throw new NotFoundException("id=`({$id}` not found)");
        }

        return (new TaskDto())
            ->setId($result['id'])
            ->setAddTimestamp($result['add_timestamp'])
            ->setBody($result['body'])
            ->setExecTimestamp($result['exec_timestamp'])
            ->setFinishTimestamp($result['finish_timestamp'])
            ->setStatus($result['status']);
    }

    /**
     * @return TaskDto[]
     * @throws AppException
     */
    public function findAll(): array
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        $sql = "select * from {$this->table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        if (empty($result)) {
            return [];
        }

        $tasks = [];
        foreach ($result as $row) {
            $tasks[] = (new TaskDto())
                ->setId($row['id'])
                ->setAddTimestamp($row['add_timestamp'])
                ->setBody($row['body'])
                ->setExecTimestamp($row['exec_timestamp'])
                ->setFinishTimestamp($row['finish_timestamp'])
                ->setStatus($row['status']);
        }
        return $tasks;
    }

    /**
     * @throws AppException
     */
    public function insert(TaskDto $task): TaskDto
    {
        try {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            $sql = "INSERT INTO {$this->table} (body) VALUES(?) RETURNING id, add_timestamp";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([$task->body]);
            $result = $statement->fetch();
            if (empty($result)) {
                throw new AppException('Error insert task');
            }
        } catch (PDOException $e) {
            throw new AppException('Error insert task. ' . $e->getMessage());
        }

        return $task->setId($result['id'] ?? null)
            ->setAddTimestamp($result['add_timestamp'] ?? null);
    }

    /**
     * @throws AppException
     * @throws NotFoundException
     */
    public function update(TaskDto $task): TaskDto
    {
        if (empty($task->id)) {
            throw new AppException('Empty id');
        }
        $columns = [];

        if ($task->exec_timestamp !== null) {
            $columns['exec_timestamp'] = $task->exec_timestamp->format(TypeHelper::DATETIME_FORMAT_TIMESTAMP);
        }
        if ($task->finish_timestamp !== null) {
            $columns['finish_timestamp'] = $task->finish_timestamp->format(TypeHelper::DATETIME_FORMAT_TIMESTAMP);
        }
        $columns['status'] = $task->status->value;

        if (empty($columns)) {
            throw new AppException('Empty updated data');
        }

        try {
            $sql = "UPDATE {$this->table} SET " .
                implode(', ', array_map(fn($name): string => "{$name} = ?", array_keys($columns))) .
                ' WHERE id = ?';
            $statement = $this->pdo->prepare($sql);
            $statement->execute([...array_values($columns), $task->id]);
            if ($statement->rowCount() === 0) {
                /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
                throw new NotFoundException("id=`({$task->id}` not found)");
            }
            return $task;
        } catch (PDOException $e) {
            throw new AppException('Error update task. ' . $e->getMessage());
        }
    }

}