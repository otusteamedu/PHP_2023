<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusRepositoryInterface;
use App\Domain\ValueObject\Name;
use App\Infrastructure\DataMapper\StatusMapper;
use Exception;

class RepositoryStatusDb implements StatusRepositoryInterface
{
    private StatusMapper $mapper;

    /**
     * @throws Exception
     */
    public function __construct(StatusMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @throws Exception
     */
    public function findByName(Name $name): ?Status
    {
        return $this->mapper->findByName($name->getValue());
    }
}