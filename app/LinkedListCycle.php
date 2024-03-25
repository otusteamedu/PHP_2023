<?php

declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        $slow_pointer = $head;
        $fast_pointer = $head;

        while ($fast_pointer !== null && $fast_pointer->next !== null) {
            $slow_pointer = $slow_pointer->next;
            $fast_pointer = $fast_pointer->next->next;

            if ($slow_pointer === $fast_pointer) {
                return true;
            }
        }

        return false;
    }
}
