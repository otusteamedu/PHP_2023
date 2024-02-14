<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Status;
use App\Domain\ValueObject\Name;

interface StatusRepositoryInterface
{
    public function findByName(Name $name): ?Status;
}
