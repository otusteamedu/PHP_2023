<?php
declare(strict_types=1);

class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $mergedList = new ListNode();
        $pointerToCurrentNode = $mergedList;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $pointerToCurrentNode->next = $list1;
                $list1 = $list1->next;
            } else {
                $pointerToCurrentNode->next = $list2;
                $list2 = $list2->next;
            }

            $pointerToCurrentNode = $pointerToCurrentNode->next;
        }

        if ($list1 !== null) {
            $pointerToCurrentNode->next = $list1;
        }

        if ($list2 !== null) {
            $pointerToCurrentNode->next = $list2;
        }

        return $mergedList->next;
    }
}

class ListNode {
     public $val = 0;
     public $next = null;
     function __construct($val = 0, $next = null) {
                 $this->val = $val;
                 $this->next = $next;
     }
}