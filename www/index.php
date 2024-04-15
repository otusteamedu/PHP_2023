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
        $tmp = null;
        if ($list1 == null) {
            $tmp = $list2;
        } elseif ($list2 == null) {
            $tmp = $list1;
        } elseif ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);
            $tmp = $list1;
        } elseif ($list1->val >= $list2->val) {
            $list2->next = $this->mergeTwoLists($list2->next, $list1);
            $tmp = $list2;
        }
        return $tmp;
    }
}