<?php

class ListNode
{
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

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
        $listResult = new ListNode();
        $currentListResult = $listResult;

        while ($list1 && $list2) {
            if ($list2->val < $list1->val) {
                $currentListResult->next = $list2;
                $list2 = $list2->next;
                $currentListResult = $currentListResult->next;
                continue;
            }

            $currentListResult->next = $list1;
            $list1 = $list1->next;
            $currentListResult = $currentListResult->next;
        }

        if ($list1) {
            $currentListResult->next = $list1;
        }

        if ($list2) {
            $currentListResult->next = $list2;
        }

        return $listResult->next;
    }
}
