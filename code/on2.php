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
        $nx1 = $list1;
        $nx2 = $list2;
        while ($nx1 || $nx2) {
            $item1 = $nx1->val;

            while ($nx2) {
                $item2 = $nx2->val;
                $nx2 = $nx2->next;
                if ($item1 <= $item2) {
                    $nx1->next = new ListNode($item2, $nx1->next);
                    $nx1 = $nx1->next;
                    break;
                }
            }

            $nx1 = $nx1->next;
        }

        return $list1;

        //Сложность O(n2), до конца не работает ибо не учтено то что массивы могут быть разными по количеству элементов
    }
}