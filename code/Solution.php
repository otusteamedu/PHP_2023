<?php

namespace app;

require './ListNode.php';

class Solution
{

    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if ($list1 === null && $list2 === null) {
            return null;
        }
        if ($list1 === null) {
            return $list2;
        }
        if ($list2 === null) {
            return $list1;
        }
        $head = $list = new ListNode();

        while ($list1 !== null || $list2 !== null) {
            if (($list1 <= $list2 && $list1 !== null) || $list2 === null) {
                $head->next = new ListNode($list1->val);
                $list1 = $list1->next;
            } else {
                $head->next = new ListNode($list2->val);
                $list2 = $list2->next;
            }

            $head = $head->next;
        }

        return $list->next;
    }
}
