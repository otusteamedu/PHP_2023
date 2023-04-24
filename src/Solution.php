<?php

namespace Yakovgulyuta\Hw6;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {

        $list3 = new ListNode(null, null);
        $prev = $list3;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $prev->next = $list1;
                $list1 = $list1->next;
            } else {
                $prev->next = $list2;
                $list2 = $list2->next;
            }
            $prev = $prev->next;
        }

        if ($list1 === null) {
            $prev->next = $list2;
        }

        if ($list2 === null) {
            $prev->next = $list1;
        }

        return $list3->next;
    }
}
