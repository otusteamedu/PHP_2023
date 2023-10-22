<?php

namespace App\Application\UseCase;

use App\Application\UseCase\AbstractSearch;

class SearchByTitleCategory extends AbstractSearch
{
    public function __invoke($title, $category): array
    {
        return $this->bookRepository->searchByTitleCategory($title, $category);
    }
}
