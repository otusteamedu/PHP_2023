<?php

declare(strict_types=1);

namespace Vp;

class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
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
