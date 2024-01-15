<?php

declare(strict_types=1);

namespace Yalanskiy\ActiveRecord\Models;

use PDO;
use PDOStatement;

/**
 * Class Article
 */
class Article
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $text = null;
    private ?array $tags = null;
    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
        $this->selectAllStatement = $pdo->prepare('SELECT * FROM articles');
        $this->insertStatement = $pdo->prepare('INSERT INTO articles (title, text) VALUES (?, ?)');
        $this->updateStatement = $pdo->prepare('UPDATE articles SET title = ?, text = ? WHERE id = ?');
        $this->deleteStatement = $pdo->prepare('DELETE FROM articles WHERE id = ?');
    }

    public function findOneById(int $id): self
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$result['id'])
            ->setTitle($result['title'])
            ->setText($result['text']);
    }

    public function findAll(): array
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();

        $result = [];
        while ($row = $this->selectAllStatement->fetch(PDO::FETCH_ASSOC)) {
            $result[] = (new self($this->pdo))
                ->setId((int)$row['id'])
                ->setTitle($row['title'])
                ->setText($row['text']);
        }

        return $result;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getTags(): array
    {
        if ($this->tags !== null) {
            return $this->tags;
        }
        return $this->tags = (new Tag($this->pdo))->findAllByArticle($this->id);
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->title,
            $this->text,
        ]);

        $this->id = (int)$this->pdo->lastInsertId();

        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->title,
            $this->text,
            $this->id,
        ]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStatement->execute([$id]);

        $this->id = null;

        return $result;
    }
}
