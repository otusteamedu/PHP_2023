<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\Pagination;
use App\Domain\ValueObject\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineNewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function nextId(): Id
    {
        return new Id(
            $this->getEntityManager()
                ->getConnection()
                ->executeQuery('SELECT nextval(\'news_id_seq\')')
                ->fetchOne()
        );
    }

    public function firstById(Id $id): ?News
    {
        return $this
            ->createQueryBuilder('n')
            ->where('n.id = :id')
            ->setParameter('id', $id->getValue())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function firstOrFailById(Id $id): News
    {
        $news = $this->firstById($id);

        if (null === $news) {
            throw new NotFoundException(sprintf('News "%s" not found.', $id));
        }

        return $news;
    }

    public function countAll(): int
    {
        return (int) $this
            ->createQueryBuilder('n')
            ->select('COUNT(n) as count')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function part(Pagination $pagination): array
    {
        return $this
            ->createQueryBuilder('n')
            ->orderBy('n.id', 'DESC')
            ->setMaxResults($pagination->getPerPage())
            ->setFirstResult($pagination->getOffset())
            ->getQuery()
            ->getResult();
    }
}
