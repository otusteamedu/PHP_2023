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
     *
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $resultList   = new ListNode(null, null);
        $previousNode = $resultList;

        while (
            isset($list1)
            || isset($list2)
        ) {
            if (!isset($list1)) {
                $currentNode = &$list2;
            } elseif (!isset($list2)) {
                $currentNode = &$list1;
            } elseif ($list1->val <= $list2->val) {
                $currentNode = &$list1;
            } else {
                $currentNode = &$list2;
            }

            $previousNode->next = $currentNode;
            $currentNode        = $currentNode->next;
            $previousNode       = $previousNode->next;
        }

        return $resultList->next;
    }
}
