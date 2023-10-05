<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\NotFoundException;
use App\Domain\ValueObject\Id;

interface NewsRepositoryInterface
{
    public function nextId(): Id;

    /**
     * @throws NotFoundException
     */
    public function firstOrFailById(Id $id): News;

    public function countAll(): int;

    public function part(Pagination $pagination): array;
}
