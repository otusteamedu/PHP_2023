<?php

namespace Klobkovsky\App\TwoLinkedLists;

class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public static function getIntersectionNode($headA, $headB)
    {
        $hashMap = [];

        while ($headA !== null || $headB !== null) {
            foreach ([&$headA, &$headB] as &$head) {
                if ($head === null) {
                    continue;
                }

                if (isset($hashMap[spl_object_hash($head)])) {
                    return $head;
                } else {
                    $hashMap[spl_object_hash($head)] = true;
                    $head = $head->next;
                }
            }
        }
    }
}
