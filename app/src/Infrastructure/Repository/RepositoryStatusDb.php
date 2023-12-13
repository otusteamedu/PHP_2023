<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Status;
use App\Domain\Repository\StatusInterface;
use App\Domain\ValueObject\Name;
use App\Infrastructure\DataMapper\StatusMapper;
use Exception;

class RepositoryStatusDb implements StatusInterface
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
