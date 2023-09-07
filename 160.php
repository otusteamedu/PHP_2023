<?php
/**
 * вариант с циклом
 * линейная сложность, проходим каждый элемент ровно 1 раз
 * https://leetcode.com/problems/intersection-of-two-linked-lists/submissions/
 * */
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
