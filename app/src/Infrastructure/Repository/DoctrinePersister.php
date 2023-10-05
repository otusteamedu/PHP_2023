<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\Persister;
use Doctrine\ORM\EntityManagerInterface;

class DoctrinePersister implements Persister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param object ...$entities
     */
    public function persist(...$entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }
    }
}
