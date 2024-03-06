<?php
declare(strict_types=1);

namespace App\IntersectionOfTwoLinkedLists;

class Solution
{
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $hashA = [];

        do {
            $hashA[spl_object_id($headA)] = true;

            $headA = $headA->next;
        } while ($headA !== null);

        $intersectVal = null;

        do {
            if (isset($hashA[spl_object_id($headB)])) {
                $intersectVal = $headB;

                break;
            }

            $headB = $headB->next;
        } while ($headB !== null);

        return $intersectVal;
    }
}
