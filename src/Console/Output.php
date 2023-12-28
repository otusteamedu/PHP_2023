<?php

declare(strict_types=1);

namespace App\Console;

use ConsoleTable\Table;

class Output
{
    public function printResult(array $result): void
    {
        $count = $result['total']['value'];
        echo 'Количество найденных записей: ' . $count . PHP_EOL;

        if ($count > 0) {
            $columns = ['Title', 'Category', 'Price', 'Stock'];

            $lines = [];

            foreach ($result['hits'] as $value) {
                $data = $value['_source'];
                $title = $data['title'];
                $category = $data['category'];
                $price = $data['price'];

                $stocks = [];

                foreach ($data['stock'] as $stock) {
                    $stocks[] = $stock['shop'] . ':' . $stock['stock'] . ' шт';
                }

                $lines[] = [$title, $category, $price, implode('; ', $stocks)];
            }

            $conf = ['showNumberRow' => false];

            $pt = new Table($columns, $lines, $conf);
            $pt->show();

        }
    }
}
