<?php

declare(strict_types=1);

namespace App\Music\Domain\RepositoryInterface;

use App\Music\Domain\Entity\Genre;

interface GenreRepositoryInterface
{
    public function findById(int $id): ?Genre;
}