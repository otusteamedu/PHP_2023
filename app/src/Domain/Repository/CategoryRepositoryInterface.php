<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Category;
use App\Domain\Exception\NotFoundException;
use App\Domain\ValueObject\Id;

interface CategoryRepositoryInterface
{
    public function nextId(): Id;

    /**
     * @throws NotFoundException
     */
    public function firstOrFailById(Id $id): Category;
}
