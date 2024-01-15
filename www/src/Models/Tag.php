<?php

declare(strict_types=1);

namespace Yalanskiy\ActiveRecord\Models;

use PDO;
use PDOStatement;

/**
 * Class Tag
 */
class Tag
{
    private ?int $id = null;
    private ?string $name = null;
    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectForArticleStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare('SELECT * FROM tags WHERE id = ?');
        $this->selectForArticleStatement = $pdo->prepare('SELECT * FROM tags WHERE id IN (SELECT tag_id FROM articles_tags WHERE article_id = ?) ORDER BY name ASC');
        $this->insertStatement = $pdo->prepare('INSERT INTO tags (name) VALUES (?)');
        $this->updateStatement = $pdo->prepare('UPDATE tags SET name = ? WHERE id = ?');
        $this->deleteStatement = $pdo->prepare('DELETE FROM tags WHERE id = ?');
    }

    public function findOneById(int $id): self
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$result['id'])
            ->setName($result['title']);
    }

    public function findAllByArticle(int $articleId): array
    {
        $this->selectForArticleStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectForArticleStatement->execute([$articleId]);

        $result = [];
        while ($row = $this->selectForArticleStatement->fetch(PDO::FETCH_ASSOC)) {
            $result[] = (new self($this->pdo))
                ->setId((int)$row['id'])
                ->setName($row['name']);
        }

        return $result;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->name,
        ]);

        $this->id = (int)$this->pdo->lastInsertId();

        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->name,
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
