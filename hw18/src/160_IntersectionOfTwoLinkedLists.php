<?php

namespace src;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode(ListNode $headA, ListNode $headB): ListNode
    {
        $a = $headA;
        $b = $headB;

        while ($a !== $b) {
            $a = !$a ? $headB : $a->next;
            $b = !$b ? $headA : $b->next;
        }

        return $a;
    }
}
