<?php

namespace App\Application\UseCase;

use App\Application\UseCase\AbstractSearch;

class SearchByTitleCategoryPrice extends AbstractSearch
{
    public function __invoke($title, $category, $price): array
    {
        return $this->bookRepository->searchByTitleCategoryPrice($title, $category, $price);
    }
}
