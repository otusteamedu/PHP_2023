<?php

  class ListNode {
      public $val = 0;
      public $next = null;
      function __construct($val) { $this->val = $val; }
 }


class Solution {
    /**
     * Сложность O(n)
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB) : mixed {
        $pA = $headA;
        $pB = $headB;

        while ($pA !== $pB) {
            $pA = ($pA === null) ? $headB : $pA->next;
            $pB = ($pB === null) ? $headA : $pB->next;
        }
        return $pA;
    }
}

$headA = new ListNode(4);
$headA->next = new ListNode(1);
$headA->next->next = new ListNode(8);
$headA->next->next->next = new ListNode(4);
$headA->next->next->next->next = new ListNode(5);

$headB = new ListNode(5);
$headB->next = new ListNode(6);
$headB->next->next = new ListNode(1);
$headB->next->next->next = $headA->next->next;

$solution = new Solution();
$result = $solution->getIntersectionNode($headA, $headB);
print_r($result);


