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

    public function update(int $id, array $fields): bool
    {
        unset($this->identity_map[$id]);

        $sql = "UPDATE news SET";
        foreach ($fields as $f_name => $f_val) {
            $sql .= " $f_name = ? ";
            if ($f_name != array_key_last($fields)) {
                $sql .= ', ';
            }
        }

        $sql .= " WHERE id = ? ";

        $params = array_values($fields);
        array_push($params, $id);

        $query_update = $this->pdo->prepare($sql);
        $ret = $query_update->execute($params);
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
