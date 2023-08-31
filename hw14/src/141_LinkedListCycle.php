<?php

namespace src;

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
    public function hasCycle(ListNode $head): bool
    {
        if ($head === null) {
            return false;
        }

        $node = $head;
        $nextNode = $head->next;

        while ($node !== $nextNode) {
            if ($node === null || $nextNode === null) {
                return false;
            }

            $node = $node->next;
            $nextNode = $nextNode->next->next;
        }

        return true;
    }
}
