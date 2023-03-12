<?php

use app\ListNode;
use app\Solution;

require './Solution.php';

$solution = new Solution();

$list1 = new ListNode(1, new ListNode(2, new ListNode(4)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4)));
var_dump($solution->mergeTwoLists($list1, $list2));

$list1 = null;
$list2 = null;
var_dump($solution->mergeTwoLists($list1, $list2));

$list1 = null;
$list2 = new ListNode(0);
var_dump($solution->mergeTwoLists($list1, $list2));
