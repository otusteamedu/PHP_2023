<?php

/**
 *  Рекурсивный вариант
 *  линейная сложность, проходим каждый элемент ровно 1 раз,
 * но для обхода используем рекурсивную функцию
 * https://leetcode.com/problems/intersection-of-two-linked-lists/submissions/
 */

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
    
    public static $arrHeadB = [];
    public function isIntersec( $headA, $headB)
    {
        if($headA === null || $headB === null) {
            return null;
        }
        
        if($headA === $headB) {
            return $headA;
        }
        $this->arrHeadB[spl_object_hash($headB)] = $headB;
        $res = $this->isIntersec($headA,$headB->next);
        if($res !== null) {
            return $res;
        }
        return null;
    }
    
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        if($headA === $headB) {
            return $headA;
        }
        $pA = $headA;
        do{
            if(!$this->arrHeadB) {
                $res = $this->isIntersec($pA, $headB);
            }else{
                $res = $this->arrHeadB[spl_object_hash($pA)];
            }
            
            if($res !== null) {
                return $res;
            }
        }
        while($pA = $pA->next);
        
        return null;
    }
}
