<?php

declare(strict_types=1);

use Root\App\Solution;

require __DIR__ . '/vendor/autoload.php';

// https://leetcode.com/problems/fraction-to-recurring-decimal/

$solution = new Solution();

$tests = [
    [
        'in' => [1, 2],
        'expected' => '0.5'
    ],
    [
        'in' => [2, 1],
        'expected' => '2'
    ],
    [
        'in' => [4, 333],
        'expected' => '0.(012)'
    ],
];

foreach ($tests as $test) {
    echo 'in = ', $solution->arrayToString($test['in']), PHP_EOL;
    $result = $solution->fractionToDecimal($test['in'][0], $test['in'][1]);
    echo 'fractionToDecimal = ', $result, PHP_EOL;
    echo 'expected = ', $test['expected'], PHP_EOL;
    echo '----', $test['expected'] === $result ? ' OK  ' : ' ERR ',
    '--------------------------------------------------------------------------------', PHP_EOL;
}
