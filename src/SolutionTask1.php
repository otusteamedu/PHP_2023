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
        $pointA = $headA;
        $pointB = $headB;

        while ($pointA !== $pointB) {
            $pointA = $pointA === null ? $headB : $pointA->next;
            $pointB = $pointB === null ? $headA : $pointB->next;
        }

        return $pointA;
    }
}
