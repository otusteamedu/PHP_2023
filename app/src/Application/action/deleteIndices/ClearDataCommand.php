<?php

namespace App\Application\action\deleteIndices;

use App\Infrastructure\Repository\RepositoryCommandInterface;

class ClearDataCommand
{
    private RepositoryCommandInterface $repository;

    public function __construct(RepositoryCommandInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(): void
    {
        $this->repository->clearData();
    }
}
