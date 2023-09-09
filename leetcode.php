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
        $result = [];
        $output = null;
        do {
            while ($list2 && ($list2->val <= $list1->val || !$list1)) {
                $result[] = $list2->val;
                $list2 = $list2->next;
            }

            if ($list1) {
                $result[] = $list1->val;
                $list1 = $list1->next;
            }
        } while ($list1 || $list2);

        for ($i = count($result) - 1; $i >= 0; $i--) {
            $output = new ListNode($result[$i], $output);
        }

        return $output;
    }
}