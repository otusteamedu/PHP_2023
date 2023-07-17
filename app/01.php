<?php

declare(strict_types=1);

use Root\App\ListNode;
use Root\App\Solution;

require __DIR__ . '/vendor/autoload.php';

// https://leetcode.com/problems/linked-list-cycle/

$solution = new Solution();

$tests = [];

// 1
$l0 = new ListNode(3);
$l1 = new ListNode(2);
$l2 = new ListNode(0);
$l3 = new ListNode(-4);
$l0->next = $l1;
$l1->next = $l2;
$l2->next = $l3;
$l3->next = $l1;
$tests[] = ['in' => $l0, 'expected' => true];

// 2
$l0 = new ListNode(1);
$l1 = new ListNode(2);
$l0->next = $l1;
$l1->next = $l0;
$tests[] = ['in' => $l0, 'expected' => true];

// 3
$l0 = new ListNode(1);
$tests[] = ['in' => $l0, 'expected' => false];

// 4
$tests[] = ['in' => null, 'expected' => false];

foreach ($tests as $test) {
    echo 'in = ', $solution->listToString($test['in']), PHP_EOL;
    $result = $solution->hasCycle($test['in']);
    echo 'hasCycle = ', $result, PHP_EOL;
    echo 'expected = ', $test['expected'], PHP_EOL;
    echo '----', $test['expected'] === $result ? ' OK  ' : ' ERR ',
        '--------------------------------------------------------------------------------', PHP_EOL;
}
