<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\Income;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Income>
 *
 * @method Income|null find($id, $lockMode = null, $lockVersion = null)
 * @method Income|null findOneBy(array $criteria, array $orderBy = null)
 * @method Income[]    findAll()
 * @method Income[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Income::class);
    }

    public function findByBetweenDates(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        return $this->createQueryBuilder('i')
            ->where('i.date >= :start')
            ->andWhere('i.date <= :end')
            ->orderBy('i.date')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}
