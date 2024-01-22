<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseInterface;
use App\Patterns\TableGateway\Genre;

class TableGatewayGenreController extends Controller implements GenreControllerInterface
{
    private Genre $genre;

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);

        $this->genre = new Genre($this->db()->connect());
    }

    public function getAllGenres(): void
    {
        if ($id = $this->getRequest()->input('id')) {
            $this->getOneById((int)$id);
            return;
        }

        echo json_encode($this->genre->getAllGenres());
    }

    public function getOneById(int $id): void
    {
        echo json_encode($this->genre->getOneById($id));
    }

    public function insert(): void
    {
        if (!array_key_exists('title', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        echo 'InsertId: ' . $this->genre->insert($this->getRequest()->body()['title']);
    }

    public function update(): void
    {
        if (!array_key_exists('id', $this->getRequest()->body()) || !array_key_exists('title', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        $this->genre->update((int)$this->getRequest()->body()['id'], $this->getRequest()->body()['title']);
    }

    public function delete(): void
    {
        if (!array_key_exists('id', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        $this->genre->delete((int)$this->getRequest()->body()['id']);
    }
}
