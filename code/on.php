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
    function mergeTwoLists($list1, $list2) {
        $nx1 = $list1;
        $nx2 = $list2;

        $head = $tail = new ListNode();

        while ($nx1 && $nx2) {
            if ($nx1->val < $nx2->val) {
                $tail->next = $nx1;
                $nx1 = $nx1->next;
            } else {
                $tail->next = $nx2;
                $nx2 = $nx2->next;
            }

            $tail = $tail->next;
        }

        $tail->next = $nx1 ?? $nx2;
        return $head->next;

        //Сложность o(n)
    }
}