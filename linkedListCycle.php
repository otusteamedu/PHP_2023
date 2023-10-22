<?php

declare(strict_types=1);

use App\LinkedListCycle\ListNode;
use App\LinkedListCycle\Solution;

require __DIR__ . '/vendor/autoload.php';

$first = new ListNode(3);
$second = new ListNode(2);
$third = new ListNode(0);
$fourth = new ListNode(-4);
$first->next = $second;
$second->next = $third;
$third->next = $fourth;
$fourth->next = $second;

var_dump(Solution::hasCycle($first));
