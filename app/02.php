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
    [
        'in' => [1, 9],
        'expected' => '0.(1)'
    ],
    [
        'in' => [1, 90],
        'expected' => '0.0(1)'
    ],
    [
        'in' => [1, 333],
        'expected' => '0.(003)'
    ],
    [
        'in' => [1, 17],
        'expected' => '0.(0588235294117647)'
    ],
    [
        'in' => [-50, 8],
        'expected' => '-6.25'
    ],
    [
        'in' => [7, -12],
        'expected' => '-0.58(3)'
    ],
    [
        'in' => [1, 214748364],
        'expected' => '0.00(000000465661289042462740251655654056577585848337359161441621040707904997124914069194026549138227660723878669455195477065427143370461252966751355553982241280310754777158628319049732085502639731402098131932683780538602845887105337854867197032523144157689601770377165713821223802198558308923834223016478952081795603341592860749337303449725)'
    ],
    [
        'in' => [0, -5],
        'expected' => '0'
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
