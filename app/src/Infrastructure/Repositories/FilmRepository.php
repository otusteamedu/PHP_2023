<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure\Repositories;

use Yevgen87\App\Domain\Repositories\FilmRepositoryInterface;
use Yevgen87\App\Domain\Entity\Film;
use Yevgen87\App\Domain\ValueObjects\Description;
use Yevgen87\App\Domain\ValueObjects\Title;
use Yevgen87\App\Domain\ValueObjects\Url;

class FilmRepository extends BaseRepository implements FilmRepositoryInterface
{
    public function getAll(): array
    {
        $res = $this->pdo->query('SELECT * FROM films');

        $films = [];

        foreach ($res as $row) {
            $films[] = $this->getFilm($row);
        }

        return $films;
    }

    public function insert(Film $film)
    {
        $stmt = $this->pdo->prepare("INSERT INTO films (title, description, image_preview, teaser_preview) VALUES (:title, :description, :image_preview, :teaser_preview) RETURNING id");

        $stmt->execute([
            ':title' => $film->getTitle(),
            ':description' => $film->getDescription(),
            ':image_preview' => $film->getImagePreview(),
            ':teaser_preview' => $film->getTeaserPreview(),
        ]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $this->fetchById($result['id']);
    }

    public function fetchById(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM films WHERE id=:id');

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        $res = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$res) {
            throw new \Exception('Not found', 404);
        }

        return $this->getFilm($res);
    }

    public function update(int $id, Film $film)
    {
        $sql = sprintf("UPDATE films SET title = :title, description = :description, image_preview = :image_preview, teaser_preview = :teaser_preview WHERE id = :id");

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':title' => $film->getTitle(),
            ':description' => $film->getDescription(),
            ':image_preview' => $film->getImagePreview(),
            ':teaser_preview' => $film->getTeaserPreview(),
        ]);

        return $this->fetchById($id);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM films WHERE id=:id');

        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    private function getFilm(array $rawFilm)
    {
        $film = new Film(
            $rawFilm['id'],
            new Title($rawFilm['title']),
            new Description($rawFilm['description']),
            new Url($rawFilm['image_preview']),
            new Url($rawFilm['teaser_preview'])
        );

        return $film->toArray();
    }
}
