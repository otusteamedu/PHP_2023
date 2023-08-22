<?php

declare(strict_types=1);

namespace App\News\Infrastructure\Repository;

use App\News\Domain\Orm\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Category::class);
    }
}
