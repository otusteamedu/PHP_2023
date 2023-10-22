<?php

namespace App\Application\UseCase;

use App\Application\UseCase\AbstractSearch;
use App\Domain\Repository\BookRepositoryInterface;

class SearchByTitle extends AbstractSearch
{
    public function __invoke($title): array
    {
        return $this->bookRepository->searchByTitle($title);
    }
}
