<?php

/**
    Рекурсивный вариант
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

/*$inresetNode = new ListNode('c1', new ListNode('c2',new ListNode('c3')));

$headA = new ListNode('a1',
    new ListNode('a2',$inresetNode));


$headB = new ListNode('b1',
        new ListNode('b2',
            new ListNode('b3',$inresetNode)));*/


$list2 = new ListNode('2');
$headA = new ListNode('1',$list2);

$headB = $list2;
var_dump($headA === $headB);
$sol = new Solution();
$res = $sol->getIntersectionNode($headA, $headB);
echo '<pre>'.print_r([$res], 1).'</pre>'.__FILE__.' # '.__LINE__;//test_delete
