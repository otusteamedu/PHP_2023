<?php

declare(strict_types=1);

namespace App\Domain\Repository;

interface PersisterInterface
{
    public function persist($entity): void;
}
