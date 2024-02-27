<?php

declare(strict_types=1);

namespace App;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

// сложность O(m + n)
class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        if ($headA === $headB) {
            return $headA;
        }

        $lengthA = 1;
        $lengthB = 1;

        $chainA = $headA;
        $chainB = $headB;

        while ($chainA->next !== null) {
            $lengthA++;
            $chainA = $chainA->next;
        }

        while ($chainB->next !== null) {
            $lengthB++;
            $chainB = $chainB->next;
        }

        $skipA = max($lengthB - $lengthA, 0);
        $skipB = max($lengthA - $lengthB, 0);
        $length = max($lengthA, $lengthB);

        $chainA = $headA;
        $chainB = $headB;

        for ($i = 0; $i < $length; $i++) {
            if ($skipA > 0) {
                $skipA--;
            } else {
                $chainA = $chainA->next;
            }

            if ($skipB > 0) {
                $skipB--;
            } else {
                $chainB = $chainB->next;
            }

            if ($chainA === $chainB) {
                return $chainA;
            }
        }

        return null;
    }
}
