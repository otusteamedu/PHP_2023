<?php

declare(strict_types=1);

namespace VLebedev\BookShop\Console;

class Output
{
    public function printResult(array $result): void
    {
        if (isset($result['success'])) {
            echo $result['success'];
            return;
        }

        if (!count($result)) {
            echo 'No book has been found';
        }

        foreach ($result as $item) {
            echo 'Title: ' . $item['_source']['title'] . ' --- ' .
                'SKU: ' . $item['_source']['sku'] . ' --- ' .
                'Category: ' . $item['_source']['category'] . ' --- ' .
                'Price: ' . $item['_source']['price'] . ' --- ' . PHP_EOL;
            echo 'Stock: ';
            foreach ($item['_source']['stock'] as $stock) {
                echo $stock['shop'] . ': ' . $stock['stock'] . PHP_EOL;
            }
            echo '---------------------------------------------------------' . PHP_EOL;
        }
    }
}