<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class ListNode {
    public $val;
    public $next;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {

    function getIntersectionNode($headA, $headB) {
        $tailA = null;
        $tailB = null;

        $currentA = $headA;
        $currentB = $headB;

        $lenA = 0;
        $lenB = 0;
        while ($currentA !== null) {
            $lenA++;
            $tailA = $currentA;
            $currentA = $currentA->next;
        }
        while ($currentB !== null) {
            $lenB++;
            $tailB = $currentB;
            $currentB = $currentB->next;
        }

        if ($tailA !== $tailB) {
            return null;
        }

        $currentA = $headA;
        $currentB = $headB;

        $diff = abs($lenA - $lenB);
        if ($lenA > $lenB) {
            for ($i = 0; $i < $diff; $i++) {
                $currentA = $currentA->next;
            }
        } else {
            for ($i = 0; $i < $diff; $i++) {
                $currentB = $currentB->next;
            }
        }

        while ($currentA !== $currentB) {
            $currentA = $currentA->next;
            $currentB = $currentB->next;
        }

        return $currentA;
    }
}

$listA = new ListNode(4);
$listA->next = new ListNode(1);
$listA->next->next = new ListNode(8);
$listA->next->next->next = new ListNode(4);
$listA->next->next->next->next = new ListNode(5);

$listB = new ListNode(5);
$listB->next = new ListNode(6);
$listB->next->next = new ListNode(1);
$listB->next->next->next = $listA->next->next;

$intersectVal = 8;
$skipA = 2;
$skipB = 3;

$solution = new Solution();
$intersectionNode = $solution->getIntersectionNode($listA, $listB);

if ($intersectionNode !== null) {
    echo "Пересекались на " . $intersectionNode->val . PHP_EOL;
} else {
    echo "Никакого пересечения" . PHP_EOL;
}