<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Id;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws Exception
     */
    public function nextId(): Id
    {
        return new Id(
            $this->getEntityManager()
                ->getConnection()
                ->executeQuery('SELECT nextval(\'users_id_seq\')')
                ->fetchOne()
        );
    }

    public function firstByEmail(Email $email): ?User
    {
        return $this
            ->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email->getValue())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function firstById(Id $id): ?User
    {
        return $this
            ->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id->getValue())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
