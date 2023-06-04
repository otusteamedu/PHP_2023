<?php

namespace Models;

use MoviesCollection;
require 'MoviesCollection.php';
require 'ObjectWatcher.php';

class Movie {

    private \PDO $pdo;
    private int $id;
    private string $name;
    private string $description;
    private string $year;
    private int $movieType;

    private static $selectQuery = "select id, name, description, year, movie_type from Movies";

    private \PDOStatement $updateStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $deleteStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into Movies (name, description, year, movie_type) values (?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update Movies set name = ?, description = ?, year = ?, movie_type = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from Movies where id = ?");
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getMovieType(): int
    {
        return $this->movieType;
    }

    public function setMovieType(int $movieType): self
    {
        $this->movieType = $movieType;
        return $this;
    }

    public static function getById(\PDO $pdo, int $id): self
    {
        // сначала обращаемся к identity map
        $movie = self::getFromMap($id);
        if ($movie) {
            return $movie;
        }

        // если нет объекта - берем из БД
        $selectStmt = $pdo->prepare(self::$selectQuery.' where id = ?');
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        $movie = (new self($pdo))
            ->setId($id)
            ->setName($result['name'])
            ->setDescription($result['description'])
            ->setYear($result['year'])
            ->setMovieType($result['movie_type']);
        $movie->addToMap();
        return $movie;
    }

    public static function getByWhere(\PDO $pdo, string $operator, string $field, string $value): MoviesCollection
    {
        $whereString = ' where ' . $field . $operator . '?';
        $selectStmt = $pdo->prepare(self::$selectQuery . $whereString);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$value]);
        $result = $selectStmt->fetchAll();
        $movies = MoviesCollection::create($pdo, $result);
        return  $movies;
    }

    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->name,
            $this->description,
            $this->year,
            $this->movieType,
        ]);
        $this->id = $this->pdo->lastInsertId();
        //$this->addToMap();
        return $result;
    }

    public function update(): bool
    {
        $result = $this->updateStmt->execute([
            $this->name,
            $this->description,
            $this->year,
            $this->movieType,
            $this->id
        ]);
        //$this->addToMap();
        return $result;
    }

    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;
        return $this->deleteStmt->execute([$id]);
    }

    /**
     * Identity Map methods
     */

    private static function getFromMap($id) {
        return \ObjectWatcher::exists(Movie::class, $id);
    }

    private function addToMap() {
        \ObjectWatcher::add($this);
    }

    // some Active Record methods ...
    public function getGenre(): string
    {

    }

    public function getActors(): array
    {

    }

}