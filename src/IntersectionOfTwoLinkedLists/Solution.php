<?php

declare(strict_types=1);

namespace App\IntersectionOfTwoLinkedLists;

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = ($pointerA === null) ? $headB : $pointerA->next;
            $pointerB = ($pointerB === null) ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}


// Сложность - O(n + m); n,m - длина списков
