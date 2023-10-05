<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Subscription;
use App\Domain\Repository\Pagination;
use App\Domain\Repository\SubscriptionRepositoryInterface;
use App\Domain\ValueObject\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineSubscriptionRepositoryInterface extends ServiceEntityRepository implements SubscriptionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function nextId(): Id
    {
        return new Id(
            $this->getEntityManager()
                ->getConnection()
                ->executeQuery('SELECT nextval(\'subscriptions_id_seq\')')
                ->fetchOne()
        );
    }

    public function partByCategoryId(Id $categoryId, Pagination $pagination): array
    {
        return $this
            ->createQueryBuilder('s')
            ->where('s.category = :categoryId')
            ->setParameter('categoryId', $categoryId->getValue())
            ->setFirstResult($pagination->getOffset())
            ->setMaxResults($pagination->getPerPage())
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
    }
}
