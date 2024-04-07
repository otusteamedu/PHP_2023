<?php

declare(strict_types=1);

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
    public function getIntersectionNode($headA, $headB)
    {
        if ($headA == null || $headB == null) {
            return null;
        }

        $nodeA = $headA;
        $nodeB = $headB;

        while ($nodeA !== $nodeB) {
            $nodeA = $nodeA === null ? $headB : $nodeA->next;
            $nodeB = $nodeB === null ? $headA : $nodeB->next;
        }

        return $nodeA;
    }
}
