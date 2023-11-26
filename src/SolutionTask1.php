<?php

/**
 * https://leetcode.com/problems/intersection-of-two-linked-lists/
 */

namespace App;

class SolutionTask1
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $b = $headB;

        do {
            do {
                if ($headA === $headB) {
                    return $headA;
                } else {
                    $headB = $headB->next;
                }
            } while ($headB !== null);

            $headA = $headA->next;
            $headB = $b;
        } while ($headA !== null);

        return null;
    }
}
