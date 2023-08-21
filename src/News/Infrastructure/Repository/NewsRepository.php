<?php

declare(strict_types=1);

namespace App\News\Infrastructure\Repository;

use App\News\Domain\Contract\NewsRepositoryInterface;
use App\News\Domain\Orm\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

final class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct($registry, News::class);
    }

    public function create(News $news): void
    {
        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    public function getByPage(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        return $this->createQueryBuilder('n')
            ->orderBy('n.createdAt', 'DESC') // Adjust the sorting as needed
            ->setMaxResults($perPage)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
