<?php

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val = 0, $next = null)
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
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $output = $result = new ListNode();
        do {
            if (($list2 && $list2->val < $list1->val) || !$list1) {
                $result->next = new ListNode($list2->val);
                $list2 = $list2->next;
            } else {
                $result->next = new ListNode($list1->val);
                $list1 = $list1->next;
            }
            $result = $result->next;
        } while ($list1 || $list2);

        return $output->next;
    }
}