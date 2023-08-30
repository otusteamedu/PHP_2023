<?php

declare(strict_types=1);

namespace App\Services;

class PrepareOutputService
{
    public static function outputResult(array $items): void
    {
        $columns = [];
        $rows = [];

        foreach ($items as $i => $lines) {
            foreach ($lines as $key => $value) {
                if (!is_array($value)) {
                    $columns[$key][0] = $key;
                    $columns[$key][] = $value;

                    $rows[$i][] = $value;
                } else {
                    foreach ($value as $subKey => $subValue) {
                        $complexKey = $key . ' (' . $subValue['shop'] . ')';
                        $columns[$complexKey][0] = $complexKey;
                        $columns[$complexKey][] = $subValue['stock'];

                        $rows[$i][] = $subValue['stock'];
                    }
                }
            }
        }

        $rows = [[...array_keys($columns)], ...$rows];
        $lengths = array_values(array_map(fn($x) => max(array_map('mb_strlen', $x)), $columns));

        foreach ($rows as $row) {
            echo '| ';
            foreach ($row as $key => $data) {
                $string = (is_bool($data)) ? (($data) ? 'true' : 'false') : (string)$data;

                $lengthDelta = $lengths[$key] - mb_strlen($string, 'UTF-8');
                for ($i = 0; $i < $lengthDelta; $i++) {
                    $string .= ' ';
                }
                $string .= ' | ';

                echo $string;
            }
            echo PHP_EOL;
        }
    }
}
