<?php

declare(strict_types=1);

use Aporivaev\Hw08\ListNode;
use Aporivaev\Hw08\Solution;

require __DIR__ . '/../vendor/autoload.php';

$solution = new Solution();

$tests = [
    [
        'list1' => new ListNode(1, new ListNode(2, new ListNode(4))),
        'list2' => new ListNode(1, new ListNode(3, new ListNode(4))),
        "expected" => new ListNode(
            1,
            new ListNode(
                1,
                new ListNode(
                    2,
                    new ListNode(3, new ListNode(4, new ListNode(4)))
                )
            )
        ),
    ],
    [
        'list1' => null,
        'list2' => null,
        'expected' => null
    ],
    [
        'list1' => null,
        'list2' => new ListNode(0),
        'expected' => new ListNode(0)
    ]
];

foreach ($tests as $test) {
    echo 'list1 = ', $solution->toStringLists($test['list1']), "\n";
    echo 'list2 = ', $solution->toStringLists($test['list2']), "\n";
    echo 'expected = ', $solution->toStringLists($test['expected']), "\n";
    $result = $solution->mergeTwoLists($test['list1'], $test['list2']);
    echo 'result = ', $solution->toStringLists($result), "\n";
    echo "--" . ($solution->compareLists($test['expected'], $result) ? " OK  " : " ERR ") .
        "--------------------------------------------------------------------------------\n";
}

/* 1 */
