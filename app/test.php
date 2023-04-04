<?php

use Hw6\ListNode;
use Hw6\Solution;

require './Solution.php';

$solution = new Solution();

var_dump($solution->mergeTwoLists(
    new ListNode(1, new ListNode(2, new ListNode(4))),
    new ListNode(1, new ListNode(3, new ListNode(4)))
));
var_dump($solution->mergeTwoLists(null, null));
var_dump($solution->mergeTwoLists(null, new ListNode(0)));
