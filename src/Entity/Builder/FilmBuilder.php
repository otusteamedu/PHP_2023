<?php
declare(strict_types=1);

namespace WorkingCode\Hw13\Entity\Builder;

use WorkingCode\Hw13\Entity\Film;

class FilmBuilder
{
    public function build(array $data): Film
    {
        return (new Film())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['description']);
    }
}
