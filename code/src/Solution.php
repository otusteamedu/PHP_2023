<?php

namespace MFatjanova\MergeTwoLists;

class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if (empty($list1) && empty($list2)) {
            return null;
        }

        if (empty($list1) && !empty($list2)) {
            return $list2;
        }

        if (empty($list2) && !empty($list1)) {
            return $list1;
        }

        $result_head = new ListNode();
        $result = $result_head;
        while (!empty($list1) || !empty($list2)) {
            if ((!empty($list1) && !empty($list2) && ($list1->val <= $list2->val)) || empty($list2)) {
                $result_head->next = $list1;
                $list1 = $list1->next;
            } elseif ((!empty($list1) && ($list1->val > $list2->val)) || empty($list1)) {
                $result_head->next = $list2;
                $list2 = $list2->next;
            }

            $result_head = $result_head->next;
        }

        return $result->next;
    }
}
