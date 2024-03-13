<?php

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
    function getIntersectionNode($headA, $headB)
    {
        if (!$headA || !$headB) {
            return null;
        }

        $a = $headA;
        $b = $headB;
        while ($a !== $b) {
            if ($a->next == null && $b->next == null) {
                return null;
            }

            if ($a->next == null) {
                $a = $headB;
            } else {
                $a = $a->next;
            }

            if ($b->next == null) {
                $b = $headA;
            } else {
                $b = $b->next;
            }
        }

        return $b;
    }
}
