<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Status;
use App\Domain\ValueObject\Name;

interface StatusInterface
{
    public function findByName(Name $name): ?Status;
}
