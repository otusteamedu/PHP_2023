<?php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 * Сложность O(n^2)
 */

class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        $nodeA = $headA;
        $nodeB = $headB;
        while (is_null($nodeA)===false)
        {
            while(is_null($nodeB) === false)
            {
                if($nodeA===$nodeB)
                {
                    return $nodeA;
                }
                $nodeB=$nodeB->next;
            }
            $nodeA = $nodeA->next;
            $nodeB = $headB;
        }
        return null;
    }
}
