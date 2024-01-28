<?php

declare(strict_types=1);

namespace Yevgen87\App\Models;

class Film extends ActiveRecord
{
    /**
     * @var integer
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $image_preview;

    /**
     * @var string
     */
    public string $teaser_preview;

    /**
     * @return Film[]
     */
    public function fetchAll(): array
    {
        $res = $this->pdo->query('SELECT * FROM films');

        $films = [];

        foreach ($res as $row) {

            $films[] = $this->getFilm($row);
        }

        return $films;
    }

    public function insert(array $data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO films (title, description, image_preview, teaser_preview) VALUES (:title, :description, :image_preview, :teaser_preview) RETURNING id");

        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':image_preview' => $data['image_preview'],
            ':teaser_preview' => $data['teaser_preview'],
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

    public function update(int $id, array $data)
    {
        $fields = [];

        $bindings = [];
        $bindings[':id'] = $id;

        foreach ($data as $key => $value) {
            $fields[] = sprintf('%s = :%s', $key, $key);

            $bindings[':' . $key] = $value;
        }

        $sql = sprintf("UPDATE films SET %s WHERE id = :id", implode(', ', $fields));

        $stmt = $this->pdo->prepare($sql);

        if (!$stmt->execute($bindings)) {
            throw new \Exception('Server error');
        };

        return $this->fetchById($id);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM films WHERE id=:id');

        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function getTodayFilms()
    {
        $sql = 'select distinct f.* from films f
            join seances s ON s.film_id = f.id 
            where s.start_at::date = current_date';

        $res = $this->pdo->query($sql);

        $films = [];

        foreach ($res as $row) {
            $films[] = $this->getFilm($row);
        }

        return $films;
    }

    /**
     * @param array $rawFilm
     * @return Film
     */
    private function getFilm(array $rawFilm): Film
    {
        $film = new self();

        $film->id = $rawFilm['id'];
        $film->title = $rawFilm['title'];
        $film->description = $rawFilm['description'];
        $film->image_preview = $rawFilm['image_preview'];
        $film->teaser_preview = $rawFilm['teaser_preview'];

        return $film;
    }
}
