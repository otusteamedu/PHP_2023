<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp;

use Symfony\Component\Console\Helper\Table;

/**
 * Book service class
 */
class Book
{
    public static array $headers = [
        'Scores',
        'SKU',
        'Title',
        'Category',
        'Price',
        'Stock'
    ];

    /**
     * Fill table rows from data array
     *
     * @param Table $table
     * @param array $data
     *
     * @return void
     */
    public static function fillRows(Table $table, array $data): void
    {
        foreach ($data as $item) {
            $stock = '';

            foreach ($item['_source']['stock'] as $store) {
                $stock .= "{$store['shop']}: {$store['stock']}\n";
            }

            $table->addRow([
                number_format(floatval($item['_score']), decimals: 2),
                $item['_source']['sku'],
                $item['_source']['title'],
                $item['_source']['category'],
                $item['_source']['price'],
                $stock
            ]);
        }
    }
}
