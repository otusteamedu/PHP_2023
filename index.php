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

        $dummyNode = new ListNode();
        $tail = $dummyNode;

        while (true) {

            if ($list1 === null) {
                $tail->next = $list2;
                break;
            }

            if ($list2 === null) {
                $tail->next = $list1;
                break;
            }

            $val1 = $list1->val;
            $val2 = $list2->val;

            if ($val1 <= $val2) {
                $tail->next = $list1;
                $list1 = $list1->next;
                var_dump($list1);
            } else {
                $tail->next = $list2;
                $list2 = $list2->next;
            }
            $tail = $tail->next;
        }

        return $dummyNode->next;
    }

}
