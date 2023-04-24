<?php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head)
    {
        $hash = [];
        while ($head !== null) {
            if (in_array(spl_object_id($head), $hash)) {
                return true;
            }
            $hash[] = spl_object_id($head);
            $head = $head->next;
        }

        return false;
    }
}

$s = new Solution();
$head = new ListNode(3);
$n2 = new ListNode(2);
$n3 = new ListNode(0);
$n4 = new ListNode(-4);
$head->next = $n2;
$n2->next = $n3;
$n3->next = $n4;
$n4->next = $n2;

$s->hasCycle($head);
