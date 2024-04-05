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
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */

    function getLength($head) {
        $length = 0;
        while ($head !== null) {
            $length++;
            $head = $head->next;
        }
        return $length;
    }

    function getIntersectionNode($headA, $headB) {

        $lenA = $this->getLength($headA);
        $lenB = $this->getLength($headB);
        $lastA = $headA;
        $lastB = $headB;
        while ($lastA->next !== null) {
            $lastA = $lastA->next;
        }
        while ($lastB->next !== null) {
            $lastB = $lastB->next;
        }

        if ($lastA !== $lastB) {
            return null;
        }

        $diff = abs($lenA - $lenB);

        $longer = $lenA > $lenB ? $headA : $headB;
        $shorter = $lenA > $lenB ? $headB : $headA;
        for ($i = 0; $i < $diff; $i++) {
            $longer = $longer->next;
        }

        while ($longer !== $shorter) {
            $longer = $longer->next;
            $shorter = $shorter->next;
        }

        return $longer;
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