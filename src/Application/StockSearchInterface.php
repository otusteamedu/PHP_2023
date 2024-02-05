<?php

namespace Dimal\Hw11\Application;

use Dimal\Hw11\Domain\Entity\SearchQuery;
use Dimal\Hw11\Infrastructure\BookRepository;

interface StockSearchInterface
{
    public function search(SearchQuery $search_query): BookRepository;
}