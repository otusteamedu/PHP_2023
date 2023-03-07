<?php

namespace Hw6;

require './ListNode.php';

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        if ($list1 === null && $list2 === null) {
            return null;
        }

        if ($list1 === null && $list2 !== null) {
            return $list2;
        }

        if ($list1 !== null && $list2 === null) {
            return $list1;
        }

        $result = $last = new ListNode();

        while ($list1 !== null || $list2 !== null) {
            if ($list1 === null) {
                $last->next = $list2;
                break;
            }

            if ($list2 === null) {
                $last->next = $list1;
                break;
            }

            if ($list1->val <= $list2->val) {
                $last = $last->next = $list1;
                $list1 = $list1->next;
            } else {
                $last = $last->next = $list2;
                $list2 = $list2->next;
            }
        }

        return $result->next;
    }
}
