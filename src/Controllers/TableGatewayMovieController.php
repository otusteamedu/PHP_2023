<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseInterface;
use App\Patterns\TableGateway\Movie;

class TableGatewayMovieController extends Controller implements MovieControllerInterface
{
    private Movie $movie;

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);

        $this->movie = new Movie($this->db()->connect());
    }

    public function getAllMovies(): void
    {
        if ($id = $this->getRequest()->input('id')) {
            $this->getOneById((int)$id);
            return;
        }

        echo json_encode($this->movie->getAllMovies());
    }

    public function getOneById(int $id): void
    {
        echo json_encode($this->movie->getOneById($id));
    }

    public function insert(): void
    {
        if (
            !array_key_exists('title', $this->getRequest()->body())
            || !array_key_exists('genre_id', $this->getRequest()->body())
            || !array_key_exists('duration', $this->getRequest()->body())
            || !array_key_exists('rating', $this->getRequest()->body())
        ) {
            $this->wrongBody();
        }

        $lastId = $this->movie->insert(
        (int)$this->getRequest()->body()['genre_id'],
        $this->getRequest()->body()['title'],
        (int)$this->getRequest()->body()['duration'],
        (int)$this->getRequest()->body()['rating']);

        echo 'InsertId: ' . $lastId;
    }

    public function update(): void
    {
        if (
            !array_key_exists('id', $this->getRequest()->body())
            || !array_key_exists('title', $this->getRequest()->body())
            || !array_key_exists('genre_id', $this->getRequest()->body())
            || !array_key_exists('duration', $this->getRequest()->body())
            || !array_key_exists('rating', $this->getRequest()->body())
        ) {
            $this->wrongBody();
        }

        $this->movie->update(
        (int)$this->getRequest()->body()['genre_id'],
        $this->getRequest()->body()['title'],
        (int)$this->getRequest()->body()['duration'],
        (int)$this->getRequest()->body()['rating'],
        (int)$this->getRequest()->body()['movie_id']);
    }

    public function delete(): void
    {
        if (!array_key_exists('id', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        $this->movie->delete((int)$this->getRequest()->body()['id']);
    }
}
