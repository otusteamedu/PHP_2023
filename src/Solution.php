<?php

namespace KLobkovsky\Hw6;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public static function mergeTwoLists($list1, $list2)
    {
        if (empty($list1->val)) {
            return $list2;
        }

        if (empty($list2->val)) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $list1->next = self::mergeTwoLists($list1->next, $list2);
            return $list1;
        } else {
            $list2->next = self::mergeTwoLists($list1, $list2->next);
            return $list2;
        }
    }
}
