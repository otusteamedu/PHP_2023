<?php

namespace App\Application\action\titleSearch;

use App\Application\action\CriteriaInterface;
use App\Application\action\SearchInterface;
use App\Infrastructure\Repository\RepositoryCommandInterface;

class TitleSearchQuery implements SearchInterface
{
    private RepositoryCommandInterface $repository;

    public function __construct(RepositoryCommandInterface $repository)
    {
        $this->repository = $repository;
    }

    public function search(CriteriaInterface $criteria): array
    {
        return $this->repository->searchByTitle($criteria->getTitle());
    }
}
