<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Category;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\ValueObject\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineCategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function nextId(): Id
    {
        return new Id(
            $this->getEntityManager()
                ->getConnection()
                ->executeQuery('SELECT nextval(\'categories_id_seq\')')
                ->fetchOne()
        );
    }

    public function firstById(Id $id): ?Category
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter('id', $id->getValue())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function firstOrFailById(Id $id): Category
    {
        $category = $this->firstById($id);

        if (null === $category) {
            throw new NotFoundException(sprintf('Category "%s" not found.', $id));
        }

        return $category;
    }
}
