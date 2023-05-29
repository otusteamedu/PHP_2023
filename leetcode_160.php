<?php

declare(strict_types=1);

namespace Vp;

class Solution
{
    public function getIntersectionNode(ListNode $headA, ListNode $headB): int|ListNode
    {
        $hash = [];
        while ($headA != null) {
            $objectId = spl_object_hash($headA);
            $hash[$objectId] = $headA;
            $headA = $headA->next;
        }

        while ($headB != null) {
            $objectId = spl_object_hash($headB);
            if (array_key_exists($objectId, $hash)) {
                return $headB;
            }
            $headB = $headB->next;
        }
        return 0;
    }
}
