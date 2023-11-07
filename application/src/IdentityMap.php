<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Gesparo\HW\Entity\BaseEntity;

class IdentityMap
{
    private array $map = [];

    public function add(BaseEntity $film): void
    {
        $this->map[$film->getId()] = $film;
    }

    public function get(int $id): ?BaseEntity
    {
        return $this->map[$id] ?? null;
    }

    public function remove(int $id): void
    {
        unset($this->map[$id]);
    }
}
