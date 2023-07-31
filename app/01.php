<?php

declare(strict_types=1);

use Root\App\ListNode;
use Root\App\Solution;

require __DIR__ . '/vendor/autoload.php';

// https://leetcode.com/problems/intersection-of-two-linked-lists/

$solution = new Solution();

$tests = [];

// 1
$a1 = new ListNode(4);
$a2 = new ListNode(1);
$b1 = new ListNode(5);
$b2 = new ListNode(6);
$b3 = new ListNode(1);
$c1 = new ListNode(8);
$c2 = new ListNode(4);
$c3 = new ListNode(5);
$a1->next = $a2;
$a2->next = $c1;
$b1->next = $b2;
$b2->next = $b3;
$b3->next = $c1;
$c1->next = $c2;
$c2->next = $c3;
$tests[] = ['in' => [$a1, $b1], 'expected' => 8];

// 2
$a1 = new ListNode(1);
$a2 = new ListNode(9);
$a3 = new ListNode(9);
$b1 = new ListNode(3);
$c1 = new ListNode(2);
$c2 = new ListNode(4);
$a1->next = $a2;
$a2->next = $a3;
$a3->next = $c1;
$b1->next = $c1;
$c1->next = $c2;
$tests[] = ['in' => [$a1, $b1], 'expected' => 2];

// 3
$a1 = new ListNode(2);
$a2 = new ListNode(6);
$a3 = new ListNode(4);
$b1 = new ListNode(1);
$b2 = new ListNode(5);
$a1->next = $a2;
$a2->next = $a3;
$b1->next = $b2;
$tests[] = ['in' => [$a1, $b1], 'expected' => 0];

foreach ($tests as $test) {
    echo 'in0 = ', $solution->listToString($test['in'][0]), PHP_EOL;
    echo 'in1 = ', $solution->listToString($test['in'][1]), PHP_EOL;
    $result = $solution->getIntersectionNode($test['in'][0], $test['in'][1]);
    echo 'getIntersectionNode = ', $solution->listToString($result), PHP_EOL;
    echo 'expected = ', $test['expected'], PHP_EOL;
    echo '----', ($result === null && $test['expected'] === 0) || ($result !== null && $result->val === $test['expected']) ? ' OK  ' : ' ERR ',
        '--------------------------------------------------------------------------------', PHP_EOL;
}
