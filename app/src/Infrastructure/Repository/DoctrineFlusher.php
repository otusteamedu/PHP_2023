<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\FlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFlusher implements FlusherInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
