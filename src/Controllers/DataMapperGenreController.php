<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseInterface;
use App\Patterns\DataMapper\Genre;
use App\Patterns\DataMapper\GenreMapper;

class DataMapperGenreController extends Controller implements GenreControllerInterface
{
    private GenreMapper $genreMapper;

    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);

        $this->genreMapper = new GenreMapper($this->db()->connect());
    }

    public function getAllGenres(): void
    {
        if ($id = $this->getRequest()->input('id')) {
            $this->getOneById((int)$id);
            return;
        }

        $genres = [];

        /** @var Genre[] $result */
        $result = $this->genreMapper->getAllGenres();

        foreach ($result as $value) {
            $genres[] = [
                'genre_id' => $value->getGenreId(),
                'title' => $value->getTitle()
            ];
        }

        echo json_encode($genres);
    }

    public function getOneById(int $id): void
    {
        $genre = $this->genreMapper->findById($id);

        echo json_encode([
            'genre_id' => $genre->getGenreId(),
            'title' => $genre->getTitle()
        ]);
    }

    public function insert(): void
    {
        if (!array_key_exists('title', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        $genre = $this->genreMapper->insert($this->getRequest()->body());

        echo json_encode([
            'genre_id' => $genre->getGenreId(),
            'title' => $genre->getTitle()
        ]);
    }

    public function update(): void
    {
        if (!array_key_exists('id', $this->getRequest()->body()) || !array_key_exists('title', $this->getRequest()->body())) {
            $this->wrongBody();
        }

        $this->genreMapper->update(
            new Genre((int)$this->getRequest()->body()['id'],
                $this->getRequest()->body()['title']));
    }

    public function delete(): void
    {
    }
}
