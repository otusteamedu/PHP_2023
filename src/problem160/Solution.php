<?php

namespace src\problem160;

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        return $this->find(
            $headA,
            $headB,
            $headA,
            $headB
        );
    }

    private function find(
        ?ListNode $lA,
        ?ListNode $lB,
        ?ListNode $headA,
        ?ListNode $headB
    ): ?ListNode {
        if ($lA === $lB) {
            return $lA;
        }

        return $this->find(
            $lA ? $lA->next : $headB,
            $lB ? $lB->next : $headA,
            $headA,
            $headB
        );
    }
}
