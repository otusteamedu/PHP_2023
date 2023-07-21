<?php

namespace Sva\BookShop\Infrastructure\Elastic;

use Sva\BookShop\Domain\SearchQuery;

class FilterFactory
{
    public static function fromArgs($args): Filter
    {
        $filter = new Filter();

        $searchQuery = new SearchQuery($args['query'] ?? '');

        if (strlen($searchQuery->get())) {
            $filter->addMatch('title', $searchQuery->get());
        }

        foreach ($args as $key => $value) {
            if ($value == '') {
                continue;
            }

            if (str_starts_with($key, 'price') || str_starts_with($key, 'stock')) {
                $arKey = explode('-', $key);
                $nestedPath = false;

                if ($arKey[1] == 'from') {
                    if ($key[2] == 'equal') {
                        $type = 'gte';
                    } else {
                        $type = 'gt';
                    }
                }

                if ($arKey[1] == 'to') {
                    if ($key[2] == 'equal') {
                        $type = 'lte';
                    } else {
                        $type = 'lt';
                    }
                }

                if ($arKey[0] == 'stock') {
                    $nestedPath = 'stock.stock';
                }

                $filter->addRange($arKey[0], $type, intval($value), $nestedPath);
            } elseif (str_starts_with($key, 'category')) {
                $filter->addTerm('category', $value);
            } elseif (str_starts_with($key, 'sku')) {
                $filter->addTerm('sku', $value);
            } elseif (str_starts_with($key, 'stock')) {
                $filter->addRange('stock.stock', 'gte', $value, 'stock');
            }
        }

        return $filter;
    }
}
