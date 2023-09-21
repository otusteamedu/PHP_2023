<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Repository;

use App\Music\Domain\Entity\Genre;
use App\Music\Domain\RepositoryInterface\GenreRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GenreRepository extends ServiceEntityRepository implements GenreRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    public function findById(int $id): ?Genre
    {
        return $this->find($id);
    }
}