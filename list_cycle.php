<?php

namespace YakovGulyuta\hw14;

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $first = $head;
        $last = $head;

        while ($first != null && $first->next != null) {
            $first = $first->next;
            $last = $last->next->next;
            if ($first === $last) {
                return true;
            }
        }
        return false;
    }
}
