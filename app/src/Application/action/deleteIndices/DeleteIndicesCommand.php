<?php

namespace App\Application\action\deleteIndices;

use App\Infrastructure\Repository\RepositoryCommandInterface;

class DeleteIndicesCommand
{
    private RepositoryCommandInterface $repository;

    public function __construct(RepositoryCommandInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(): void
    {
        $indexName = 'otus-shop';
        $this->repository->client->indices()->delete(['index' => $indexName]);
    }
}
