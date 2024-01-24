<?php

declare(strict_types=1);

namespace Dimal\Hw13;

use PDO;
use PDOStatement;

class News
{
    private PDO $pdo;
    private PDOStatement $query_select;
    private PDOStatement $query_delete;
    private PDOStatement $query_insert;
    private PDOStatement $query_update;

    private array $identity_map = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->query_select = $this->pdo->prepare(
            "SELECT id, title, author, date, content, category 
            FROM news WHERE id = ?"
        );

        $this->query_insert = $this->pdo->prepare(
            "INSERT INTO news (title,author,date,content,category)
            VALUES (:title, :author, :date, :content, :category)"
        );

        $this->query_delete = $this->pdo->prepare(
            "DELETE FROM news
            WHERE id = ?"
        );

        $this->query_update = $this->pdo->prepare(
            "UPDATE news
            SET title = :title, author = :author, date = :date, content = :content, category = :category
            WHERE id = :id"
        );
    }

    public function insert(
        string $title,
        string $author,
        string $date,
        string $content,
        string $category
    ): int {
        $this->query_insert->bindParam('title', $title);
        $this->query_insert->bindParam('author', $author);
        $this->query_insert->bindParam('date', $date);
        $this->query_insert->bindParam('content', $content);
        $this->query_insert->bindParam('category', $category);

        $this->query_insert->execute();
        $id = $this->pdo->lastInsertId();

        return intval($id);
    }

    public function update(
        int $id,
        string $title,
        string $author,
        string $date,
        string $content,
        string $category
    ): bool {

        unset($this->identity_map[$id]);

        $this->query_update->bindParam('id', $id, PDO::PARAM_INT);
        $this->query_update->bindParam('title', $title);
        $this->query_update->bindParam('author', $author);
        $this->query_update->bindParam('date', $date);
        $this->query_update->bindParam('content', $content);
        $this->query_update->bindParam('category', $category);

        $ret = $this->query_update->execute();
        return $ret;
    }

    public function delete(int $id): bool
    {
        unset($this->identity_map[$id]);
        $ret = $this->query_delete->execute([$id]);
        return $ret;
    }

    public function getById(int $id): array
    {
        if (isset($this->identity_map[$id])) {
            return $this->identity_map[$id];
        }
        $this->query_select->execute([$id]);
        $ret = $this->query_select->fetch(PDO::FETCH_ASSOC);

        $this->identity_map[$id] = $ret;

        return $ret;
    }
}
