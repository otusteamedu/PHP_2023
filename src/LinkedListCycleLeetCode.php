<?php

declare(strict_types=1);

namespace Art\Php2023;

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
    function hasCycle($head): bool
    {
        if ($head == null) {
            return false;
        }

        $fastNode = $head;

        while ($fastNode && $fastNode->next) {
            $head = $head->next;
            $fastNode = $fastNode->next->next;

            if ($fastNode === $head) {
                return true;
            }
        }

        return false;
    }
}
