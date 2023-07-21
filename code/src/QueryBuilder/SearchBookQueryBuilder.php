<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\QueryBuilder;

class SearchBookQueryBuilder extends SearchQueryBuilder
{
    public function setTitle(string $title): SearchBookQueryBuilder
    {
        $this->setMust('title', $title);

        return $this;
    }

    public function setInStock(): SearchBookQueryBuilder
    {
        $this->setRange('stock.stock', 0, self::MORE_THAN);

        return $this;
    }

    public function setPriceBefore(int $priceBefore): SearchBookQueryBuilder
    {
        $this->setRange('price', $priceBefore, self::LESS_THAN);

        return $this;
    }

    public function setPriceFrom(int $priceFrom): SearchBookQueryBuilder
    {
        $this->setRange('price', $priceFrom, self::MORE_THAN);

        return $this;
    }
}
