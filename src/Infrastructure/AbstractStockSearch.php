<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Domain\Entity\SearchQuery;

abstract class AbstractStockSearch
{
    abstract public function search(SearchQuery $search_query);
}
