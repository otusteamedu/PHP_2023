<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */

class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        if (!$list1->val) {
            return $list2;
        }

        if (!$list2->val) {
            return $list1;
        }

        $result = $current = $list1;
        $secondary = $list2;
        if ($list1->val < $list2->val) {
            $result = $current = $list2;
            $secondary = $list1;
        }


        while (!is_null($current->next)) {
            if ($current->next->val < $secondary->val) {
                $current = $current->next;
                continue;
            }

            $temporary = $current->next;
            $current->next = $secondary;
            $current = $secondary;
            $secondary = $temporary;
        }

        $current->next = $secondary;

        return $result;
    }
}
