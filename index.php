<?php

require 'vendor/autoload.php';

use Yakovgulyuta\Hw6\ListNode;
use Yakovgulyuta\Hw6\Solution;



$list1 = new ListNode(1, new  ListNode(2, new  ListNode(4)));
$list2 = new ListNode(1, new  ListNode(3, new  ListNode(4)));

$list3 = new ListNode(null);
$list4 = new ListNode(null);

$list5 = new ListNode(null);
$list6 = new ListNode();



var_dump((new Solution())->mergeTwoLists($list1, $list2));

var_dump((new Solution())->mergeTwoLists($list3, $list4));

var_dump((new Solution())->mergeTwoLists($list5, $list6));
