<?php

declare(strict_types=1);

use User\Php2023\ListNode;
use User\Php2023\Solution;

require 'vendor/autoload.php';

function createLinkedList($values) {
    $dummy = new ListNode(0);
    $current = $dummy;
    foreach ($values as $value) {
        $current->next = new ListNode($value);
        $current = $current->next;
    }
    return $dummy->next;
}

function getNodeByIndex($head, $index) {
    $current = $head;
    for ($i = 0; $i < $index && $current !== null; $i++) {
        $current = $current->next;
    }
    return $current;
}

$listA1 = createLinkedList([4,1,8,4,5]);
$listB1 = createLinkedList([5,6,1]);
$intersectNode1 = getNodeByIndex($listA1, 2);
$tailB1 = getNodeByIndex($listB1, 2);
$tailB1->next = $intersectNode1;

$listA2 = createLinkedList([1,9,1,2,4]);
$listB2 = createLinkedList([3]);
$intersectNode2 = getNodeByIndex($listA2, 3);
$tailB2 = $listB2;
$tailB2->next = $intersectNode2;
$listA3 = createLinkedList([2,6,4]);
$listB3 = createLinkedList([1,5]);


$solution = new Solution();
echo "Сложность: O(n)" . PHP_EOL;
echo "Сложность(память): O(1)" . PHP_EOL;
$intersection1 = $solution->getIntersectionNode($listA1, $listB1);
echo "Example 1: " . ($intersection1->val ?? "No intersection") . PHP_EOL;

$intersection2 = $solution->getIntersectionNode($listA2, $listB2);
echo "Example 2: " . ($intersection2->val ?? "No intersection") . PHP_EOL;

$intersection3 = $solution->getIntersectionNode($listA3, $listB3);
echo "Example 3: " . ($intersection3->val ?? "No intersection") . PHP_EOL;
