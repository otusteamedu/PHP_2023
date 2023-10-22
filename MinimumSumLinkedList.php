<?php

namespace App;

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class MinimumSumLinkedList
{
    /**
     * Сложность O(n)
     *
     * @param  $headA
     * @param  $headB
     * @return mixed
     */
    public function getIntersectionNode($headA, $headB): mixed
    {
        $pA = $headA;
        $pB = $headB;

        while ($pA !== $pB) {
            $pA = ($pA === null) ? $headB : $pA->next;
            $pB = ($pB === null) ? $headA : $pB->next;
        }

        return $pA;
    }
}
