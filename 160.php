<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class ListNode {
     public $val = 0;
     public $next = null;
     function __construct($val,$next = null) {
         $this->val = $val;
         $this->next = $next;
     }
}

class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if($headA === $headB) {
            return $headA;
        }
        $arrPosA = [];
        $arrPosB = [];
        $pA = $headA;
        $pB = $headB;
        
        while(1==1){
            if($pA->next!==null && $pA->next === $pB->next){
                return $pA->next;
            }
            
            $hashNodeA = spl_object_hash($pA);
            $arrPosA[$hashNodeA] = &$pA;
            if($arrPosB[$hashNodeA]){
                return $pA;
            }
            
            $hashNodeB = spl_object_hash($pB);
            $arrPosB[$hashNodeB] = &$pB;
            if ($arrPosA[$hashNodeB]) {
                return $pB;
            }
            
            if($pA->next !== null){
                $pA = $pA->next;
            }
            
            if($pB->next !== null) {
                $pB = $pB->next;
            }
            if($pA->next === null && $pB->next === null){
                if($pA->val === $pB->val){
                    return $pA;
                }
                break;
            }
        }
        return null;
    }
}
