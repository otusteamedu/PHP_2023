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
class MergeTwoList
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        if($list1 === null) {
            return $list2;
        }

        if($list2 === null) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);
            return $list1;
        } else {
            $list2->next = $this->mergeTwoLists($list2->next, $list1);
            return $list2;
        }
    }
}