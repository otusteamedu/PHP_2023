<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Repository;

use App\Music\Domain\Entity\User;
use App\Music\Domain\RepositoryInterface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findById(string $id): ?User
    {
        return $this->find($id);
    }
}