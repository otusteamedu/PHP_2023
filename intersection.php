<?php

/
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    function make_array($list) {
        if ($list == null) return [];
        if ($list->next == null) return [$list];
        
        $result = [$list];
        while ($list->next != null) {
            $result[] = $list->next;
            $list = $list->next;
        }

        return array_values(array_reverse($result));
    }
    
    /
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        $listA = $this->make_array($headA);
        $listB = $this->make_array($headB);
        
        $intersection = null;
        for ($i = 0; $i < min(count($listA), count($listB)); $i++) {
            if ($listA[$i] === $listB[$i]) {
                $intersection = $listA[$i];                
            } else {
                break;
            }
        }

        return $intersection;
    }
}