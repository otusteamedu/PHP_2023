<?php

include './vendor/autoload.php';
include './include/functions.php';

use Sva\Solution;
use Sva\ListNode;

$solution = new Solution();
$list1 = new ListNode(1);
$solution->addToList($list1, new ListNode(2));
$solution->addToList($list1, new ListNode(4));

$list2 = new ListNode(1);
$solution->addToList($list2, new ListNode(3));
$solution->addToList($list2, new ListNode(4));

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = null;
$list2 = new ListNode(0);

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = new ListNode(2);
$list2 = new ListNode(1);

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = new ListNode(-9);
$solution->addToList($list1, new ListNode(3));

$list2 = new ListNode(5);
$solution->addToList($list2, new ListNode(7));

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);
