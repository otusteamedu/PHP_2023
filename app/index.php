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
        $head = $linkedList = new ListNode();

        while ($list1 || $list2) {
            if ($list1 && !$list2
                || $list1 && $list1->val < $list2->val) {
                $linkedList->next = new ListNode($list1->val);
                $linkedList = $linkedList->next;
                $list1 = $list1->next;
            } elseif (!$list1 && $list2
                || $list2 && $list1->val > $list2->val) {
                $linkedList->next = new ListNode($list2->val);
                $linkedList = $linkedList->next;
                $list2 = $list2->next;
            } else {
                $_lastNode = new ListNode($list2->val);
                $linkedList->next = new ListNode($list1->val, $_lastNode);
                $linkedList = $_lastNode;
                $list1 = $list1->next;
                $list2 = $list2->next;
            }
        }

        return $head->next;
    }
}
