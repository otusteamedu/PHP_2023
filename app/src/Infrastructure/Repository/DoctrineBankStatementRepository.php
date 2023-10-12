<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\BankStatement;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Domain\ValueObject\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineBankStatementRepository extends ServiceEntityRepository implements BankStatementRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankStatement::class);
    }

    /**
     * @throws Exception
     */
    public function nextId(): Id
    {
        return new Id(
            $this->getEntityManager()
                ->getConnection()
                ->executeQuery('SELECT nextval(\'bank_statements_id_seq\')')
                ->fetchOne()
        );
    }

    public function firstById(Id $id): ?BankStatement
    {
        return $this
            ->createQueryBuilder('bs')
            ->where('bs.id = :id')
            ->setParameter('id', $id->getValue())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function firstOrFailById(Id $id): BankStatement
    {
        $bankStatement = $this->firstById($id);

        if (null === $bankStatement) {
            throw new NotFoundException('Bank Statement not found.');
        }

        return $bankStatement;
    }
}
