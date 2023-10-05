<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface Persister
{
    public function persist(object ...$entities): void;
}
