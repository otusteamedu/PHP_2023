<?php

namespace Dimal\Hw11\Application;

use Dimal\Hw11\Infrastructure\BookRepository;

interface StockSearchInterface
{
    public function search(SearchQueryDTO $search_query): BookRepository;
}
