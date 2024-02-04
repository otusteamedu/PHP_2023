<?php

declare(strict_types=1);

namespace Yevgen87\App\Services;

use Yevgen87\App\Models\Film;

class FilmService
{
    /**
     * @var Film
     */
    private Film $model;

    public function __construct()
    {
        $this->model = new Film();
    }

    public function findAll()
    {
        return $this->model->getTodayFilms();
    }

    public function store(array $data)
    {
        return $this->model->insert($data);
    }

    public function getById(int $id)
    {
        return $this->model->fetchById($id);
    }

    public function update(int $id, array $data)
    {
        return $this->model->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->model->delete($id);
    }
}
