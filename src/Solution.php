<?php

namespace HW11\Elastic;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

/**
 * имеет временную сложность O(n)
 */
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        if ($head === null) {
            return false;
        }
        $slow = $head;
        $fast = $head->next;
        while ($fast !== null && $fast->next !== null) {
            if ($slow === $fast) {
                return true;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }
        return false;
    }
}
