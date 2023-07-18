<?php

use Sva\BookShop\Infrastructure\Elastic\Filter;

return [
    'health' => function () {
        $index = new \Sva\BookShop\Infrastructure\Elastic\Index();
        $index->helthcheck();
    },
    'create-index' => function () {
        $index = new \Sva\BookShop\Infrastructure\Elastic\Index();
        $r = $index->create();

        if ($r) {
            echo "Index created\n";
        } else {
            echo "Index not created\n";
        }
    },
    'delete-index' => function () {
        $index = new \Sva\BookShop\Infrastructure\Elastic\Index();
        $index->deleteIndex();
    },
    'load-data' => function () {
        $index = new \Sva\BookShop\Infrastructure\Elastic\Index();
        $index->loadData();
    },
    'search' => function ($args) {
        $searchQuery = $args['query'] ?? '';
        $filter = new Filter();

        foreach ($args as $key => $value) {
            if ($value == '') {
                continue;
            }

            if (str_starts_with($key, 'price') || str_starts_with($key, 'stock')) {
                $arKey = explode('-', $key);
                $nestedPath = false;

                if ($arKey[1] == 'from') {
                    if ($key[2] == 'equal') {
                        $type = 'gte';;
                    } else {
                        $type = 'gt';
                    }
                }

                if ($arKey[1] == 'to') {
                    if ($key[2] == 'equal') {
                        $type = 'lte';;
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

        $index = new \Sva\BookShop\Infrastructure\Elastic\Index();
        $searchQuery = new \Sva\BookShop\Domain\SearchQuery($searchQuery);

        if (strlen($searchQuery->get())) {
            $filter->addMatch('title', $searchQuery->get());
        }

        /**
         * - Получить аргументы фильтрации
         * - Разобрать их и сформировать массив
         */

        $arResult = $index->search($filter);

        $out = new Symfony\Component\Console\Output\ConsoleOutput();
        $table = new \Symfony\Component\Console\Helper\Table($out);
        $table->setHeaders(['Title', 'Category', 'Price']);
        foreach ($arResult['hits']['hits'] as $book) {
//            var_dump($book);

            $stock = '';
            foreach ($book['_source']['stock'] as $key => $value) {
                $stock .= $value['shop'] . ': ' . $value['stock'] . "; ";
            }

            $table->addRow([
                $book['_source']['title'],
                $book['_source']['category'],
                $book['_source']['price'],
                $stock

            ]);
        }
        $table->render();
    }
];
