<?php

namespace Sherweb;

class App
{
    public function run()
    {
        $node1 = new ListNode(1, new ListNode(2, new ListNode(4)));
        $node2 = new ListNode(1, new ListNode(3, new ListNode(4)));

        $solution = new Solution();
        $result = $solution->mergeTwoLists($node1, $node2);

        while ($result != null) {
            echo $result->val . " ";
            $result = $result->next;
        }
    }
}