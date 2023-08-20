<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\PostDto;
use App\Entity\Collection;
use App\Entity\Post;
use DateTimeImmutable;
use PDO;
use PDOStatement;

class PostMapper
{
    public const TABLE_NAME = 'post';

    private PDO $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    private PDOStatement $selectAllStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $tableName = self::TABLE_NAME;

        $this->selectStatement = $pdo->prepare(
            "select title, content, created_by, created_at from $tableName where id = ?"
        );

        $this->insertStatement = $pdo->prepare(
            "insert into $tableName (title, content, created_by, created_at) values (?, ?, ?, ?)"
        );
        $this->updateStatement = $pdo->prepare(
            "update $tableName set title = ?, content = ?, created_by = ? where id = ?"
        );
        $this->deleteStatement = $pdo->prepare(
            "delete from $tableName where id = ?"
        );
        $this->selectAllStatement = $pdo->prepare(
            "select id, title, content, created_by, created_at from $tableName"
        );
    }

    public function findById(int $id): ?Post
    {
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        if ($result === false) {
            return null;
        }

        return new Post(
            $id,
            $result['title'],
            $result['content'],
            $result['created_by'],
            $result['created_at']
        );
    }

    public function findAll(): Collection
    {
        $this->selectAllStatement->execute();
        $result = $this->selectAllStatement->fetchAll();

        $collection = new Collection();
        foreach ($result as $item) {
            $collection->add(
                new Post(
                    (int)$item['id'],
                    $item['title'],
                    $item['content'],
                    $item['created_by'],
                    $item['created_at']
                )
            );
        }

        return $collection;
    }

    public function insert(PostDto $postDto): Post
    {
        $createdAt = (new DateTimeImmutable())->format('Y-m-d');

        $this->insertStatement->execute([
            $postDto->title,
            $postDto->content,
            $postDto->createdBy,
            $createdAt,
        ]);

        return new Post(
            (int)$this->pdo->lastInsertId(),
            $postDto->title,
            $postDto->content,
            $postDto->createdBy,
            $createdAt,
        );
    }

    public function update(PostDto $postDto): void
    {
        $this->updateStatement->execute([
            $postDto->title,
            $postDto->content,
            $postDto->createdBy,
            $postDto->id,
        ]);
    }

    public function delete(int $id): void
    {
        $this->deleteStatement->execute([
            $id
        ]);
    }
}
