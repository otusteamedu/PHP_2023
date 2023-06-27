<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use KLobkovsky\Hw6\ListNode;
use KLobkovsky\Hw6\Solution;

$list1 = new ListNode(1, new ListNode(2, new ListNode(4, null)));
$list2 = new ListNode(1, new ListNode(3, new ListNode(4, null)));
$listEmpty = new ListNode(null, null);
$listZero = new ListNode(0, null);

var_export(Solution::mergeTwoLists($list1, $list2));
var_export(Solution::mergeTwoLists($listEmpty, $listEmpty));
var_export(Solution::mergeTwoLists($listEmpty, $listZero));
