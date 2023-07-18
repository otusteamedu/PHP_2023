<?php

declare(strict_types=1);

use Root\App\Solution;

require __DIR__ . '/vendor/autoload.php';

// https://leetcode.com/problems/letter-combinations-of-a-phone-number/

$solution = new Solution();

$tests = [
    [
        'in' => '23',
        'expected' => ["ad","ae","af","bd","be","bf","cd","ce","cf"]
    ],
    [
        'in' => '',
        'expected' => []
    ],
    [
        'in' => '2',
        'expected' => ["a","b","c"]
    ]
];

foreach ($tests as $test) {
    echo 'in = ', $test['in'], PHP_EOL;
    $result = $solution->letterCombinations($test['in']);
    echo 'letterCombinations = ', $solution->arrayToString($result), PHP_EOL;
    echo 'expected = ', $solution->arrayToString($test['expected']), PHP_EOL;
    echo '----', $solution->compareArray($result, $test['expected'], count($test['expected'])) ? ' OK  ' : ' ERR ',
    '--------------------------------------------------------------------------------', PHP_EOL;
}
