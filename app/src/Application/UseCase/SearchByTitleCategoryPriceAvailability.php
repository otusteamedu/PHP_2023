<?php

namespace App\Application\UseCase;

use App\Application\UseCase\AbstractSearch;

class SearchByTitleCategoryPriceAvailability extends AbstractSearch
{
    public function __invoke($title, $category, $price): array
    {
        return $this->bookRepository->searchByTitleCategoryPriceAvailability($title, $category, $price);
    }
}
