<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use User\Php2023\ListNode;
use User\Php2023\Solution;


$solution = new Solution();

//$head = ListNode::createCycle([3, 2, 0, -4], 1);
//$head = ListNode::createCycle([1, 2], 0);
$head = ListNode::createCycle([1], -1);
echo 'Сложность: O(n)' . PHP_EOL;
echo 'Память: O(n)' . PHP_EOL;
echo 'Решение: ' . var_export($solution->hasCycle($head), true) . PHP_EOL;
