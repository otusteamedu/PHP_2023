<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\Repositories;

use Yevgen87\App\Domain\Entity\Film;

interface FilmRepositoryInterface
{
    public function select(array $params);

    public function insert(Film $film);

    public function fetchById(int $id);

    public function update(int $id, Film $film);

    public function delete(int $id);
}
