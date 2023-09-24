<?php

declare(strict_types=1);

namespace App\Repository;

class PaymentRepository
{
    private array $storage = [];

    public function findById(int $id): array|null
    {
        foreach ($this->storage as $value) {
            if ($value['id'] === $id) {
                return $value;
            }
        }
        return null;
    }

    public function add($entity): void
    {
        $this->storage[] = $entity;
    }
}
