<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\Expense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expense>
 *
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expense::class);
    }

    public function findByBetweenDates(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->select('e')->where('e.date >= :startDate')
            ->andWhere('e.date <= :endDate')
            ->orderBy('e.date')
            ->setParameter('startDate', $start)
            ->setParameter('endDate', $end)
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
