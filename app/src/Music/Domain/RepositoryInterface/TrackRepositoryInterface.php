<?php

declare(strict_types=1);

namespace App\Music\Domain\RepositoryInterface;

use App\Music\Domain\Entity\Track;

interface TrackRepositoryInterface
{
    public function add(Track $track): void;

    public function findById(int $id): ?Track;
}