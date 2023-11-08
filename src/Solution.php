<?php

declare(strict_types=1);

namespace User\Php2023;
class Solution
{

    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA === null ? $headB : $pointerA->next;
            $pointerB = $pointerB === null ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}
