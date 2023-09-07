<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution
{
    /**
     * По сложности времени O(A + B) где A и B — длины каждого связанного списка - сложность зависит от объёма входных данных
     *
     * По памяти O(1)
     *
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ListNode
    {
        $ptrA = $headA;
        $ptrB = $headB;

        while ($ptrA !== $ptrB) { // цикл, пока не найдем первый общий узел
            $ptrA = $ptrA == null ? $headB : $ptrA->next; // как только мы закончим с А, переходим к Б
            $ptrB = $ptrB == null ? $headA : $ptrB->next; // как только мы закончим с Б, переходим к А
        }

        return $ptrA;
    }
}