<?php

use MFatjanova\MergeTwoLists\ListNode;
use MFatjanova\MergeTwoLists\Solution;

require __DIR__ . '/vendor/autoload.php';

$list1 = new ListNode(1, new ListNode(2, new ListNode(5, new ListNode(8))));
$list2 = new ListNode(5, new ListNode(7));

$solution = new Solution();

echo "<pre>";
print_r($solution->mergeTwoLists($list1, $list2));
echo "</pre>";
