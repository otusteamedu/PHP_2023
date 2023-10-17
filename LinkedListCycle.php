<?php

namespace app\leetcode\linkedListCycle;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class LinkedListCycle
{
    /**
     * @param $head
     *
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        $curNode  = $head;
        $nextNode = $head;

        while ($nextNode && $nextNode->next) {
            $curNode  = $curNode->next;
            $nextNode = $nextNode->next->next;
            if ($curNode === $nextNode) {
                return true;
            }
        }

        return false;
    }

}
