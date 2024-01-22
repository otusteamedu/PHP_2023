<?php

declare(strict_types=1);

namespace App\Patterns;

use PDO;
use PDOStatement;

abstract class BaseMovie
{
    protected PDOStatement $selectOneStatement;
    protected PDOStatement $selectAllStatement;
    protected PDOStatement $insertStatement;
    protected PDOStatement $updateStatement;
    protected PDOStatement $deleteStatement;

    public function __construct(protected readonly PDO $pdo)
    {
        $this->selectOneStatement = $this->pdo->prepare(
            'SELECT	m.movie_id,	m.title, g.genre_id, g.title AS genre,	m.duration , m.rating
            FROM movies m
            INNER JOIN genres g
            ON	m.genre_id = g.genre_id
            WHERE movie_id = ?'
        );

        $this->selectAllStatement = $this->pdo->prepare(
            'SELECT	m.movie_id,	m.title, g.genre_id, g.title AS genre,	m.duration , m.rating
            FROM movies m
            INNER JOIN genres g
            ON	m.genre_id = g.genre_id'
        );

        $this->insertStatement = $this->pdo->prepare('INSERT INTO movies (genre_id, title, duration, rating) VALUES (?,?,?,?)');

        $this->updateStatement = $this->pdo->prepare('UPDATE movies SET genre_id = ?, title = ?, duration = ?, rating = ? WHERE movie_id = ?'
        );

        $this->deleteStatement = $this->pdo->prepare('DELETE FROM movies WHERE movie_id = ?');
    }
}
