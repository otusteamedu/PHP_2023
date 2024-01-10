<?php

declare(strict_types=1);

namespace App\Console;

use ConsoleTable\Table;

class Output
{
    public function printResult(array $result, array $columns): void
    {
        $count = $result['total']['value'];
        echo 'Количество найденных записей: ' . $count . PHP_EOL;

        if ($count > 0) {

            $lines = [];

            foreach ($result['hits'] as $value) {
                $data = $value['_source'];
                $row = [];

                foreach ($columns as $column) {
                    $row[] = $data[$column];
                }

                $lines[] = $row;
            }

            $conf = ['showNumberRow' => false];

            $pt = new Table($columns, $lines, $conf);
            $pt->show();
        }
    }
}
