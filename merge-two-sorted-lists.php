<?php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        if (is_null($list1->val)){
            return $list2;
        }
        if (is_null($list2->val)){
            return $list1;
        }

        $result=new ListNode;
        $progress=$result;
        while(!is_null($list1->val) || !is_null($list2->val)){
            if (is_null($list1->val)){
                while(!is_null($list2->val)){
                    $progress->next=$list2;
                    $list2=$list2->next;
                    $progress=$progress->next;
                }
                break;
            }
            if (is_null($list2->val)){
                while(!is_null($list1->val)){
                    $progress->next=$list1;
                    $list1=$list1->next;
                    $progress=$progress->next;
                }
                break;
            }

            if ($list1->val==$list2->val){
                $progress->next=$list1;
                $list1=$list1->next;
                $progress=$progress->next;

                $progress->next=$list2;
                $list2=$list2->next;
                $progress=$progress->next;
            }elseif ($list1->val<$list2->val){
                $progress->next=$list1;
                $list1=$list1->next;
                $progress=$progress->next;
            }elseif ($list2->val<$list1->val){
                $progress->next=$list2;
                $list2=$list2->next;
                $progress=$progress->next;
            }
        }
        return $result->next;
    }
}