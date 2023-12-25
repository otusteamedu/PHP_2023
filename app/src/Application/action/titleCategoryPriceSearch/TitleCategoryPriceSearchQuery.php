<?php

namespace App\Application\action\titleCategoryPriceSearch;

use App\Application\action\CriteriaInterface;
use App\Application\action\SearchInterface;
use App\Infrastructure\Repository\RepositoryCommandInterface;

class TitleCategoryPriceSearchQuery implements SearchInterface
{
    private RepositoryCommandInterface $repository;

    public function __construct(RepositoryCommandInterface $repository)
    {
        $this->repository = $repository;
    }

    public function search(CriteriaInterface $criteria): array
    {
        return $this->repository->searchByTitleCategoryPrice(
            $criteria->getTitle(),
            $criteria->getCategory(),
            $criteria->getPrice()
        );
    }
}
