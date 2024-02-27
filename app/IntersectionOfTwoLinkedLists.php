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
// сложность O(n)
class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $lengthA = 0;
        $lengthB = 0;

        $chainA = $headA;
        $chainB = $headB;

        while ($chainA !== null && $chainB !== null) {
            $lengthA++;
            $lengthB++;

            if ($chainA === $chainB) {
                return $chainA;
            }

            $chainA = $chainA->next;
            $chainB = $chainB->next;
        }

        while ($chainA !== null) {
            $lengthA++;
            $chainA = $chainA->next;
        }

        while ($chainB !== null) {
            $lengthB++;
            $chainB = $chainB->next;
        }

        $chainA = $headA;
        $chainB = $headB;

        for ($i = 0; $i < abs($lengthA - $lengthB); $i++) {
            if ($lengthA > $lengthB) {
                $chainA = $chainA->next;
            } else {
                $chainB = $chainB->next;
            }
        }

        while ($chainA !== null && $chainB !== null) {
            if ($chainA === $chainB) {
                return $chainA;
            }

            $chainA = $chainA->next;
            $chainB = $chainB->next;
        }

        return null;
    }
}
