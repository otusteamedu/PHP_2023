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

        $last = new ListNode();
        $result = $last;

        while ($list1 !== null || $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $last->next = $list1;
                $last = $last->next;
                $list1 = $list1->next;

                if ($list1 === null) {
                    $last->next = $list2;
                    $list2 = null;
                }
            } else {
                $last->next = $list2;
                $last = $last->next;
                $list2 = $list2->next;

                if ($list2 === null) {
                    $last->next = $list1;
                    $list1 = null;
                }
            }
        }

        return $result->next;
    }
}
