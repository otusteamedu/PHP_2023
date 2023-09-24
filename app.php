<?php

declare(strict_types=1);

use App\ListNode;
use App\Solution;

require __DIR__ . '/vendor/autoload.php';

$first = new ListNode(0, new ListNode(1, new ListNode(2, new ListNode(3))));
$second = new ListNode(0, new ListNode(1, new ListNode(3, new ListNode(5))));

$lists = Solution::mergeTwoLists($first, $second);

print_r($lists);
