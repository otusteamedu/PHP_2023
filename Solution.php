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
class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $merged_list = new ListNode();
        $node = $merged_list;
        while (isset($list1->val) || isset($list2->val)) {
            if (isset($list1->val) && (!isset($list2->val) || $list1->val < $list2->val)) {
                $node->next = $list1;
                $list1 = $list1->next;
            } else {
                $node->next = $list2;
                $list2 = $list2->next;
            }

            $node = $node->next;
        }
        return $merged_list->next;
    }
}
