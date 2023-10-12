<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\PersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePersister implements PersisterInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist($entity): void
    {
        $this->entityManager->persist($entity);
    }
}
