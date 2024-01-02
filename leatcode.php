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

class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public static function mergeTwoLists($list1, $list2)
    {
        $emptyListNode = new ListNode(); // Пустой список, в который будем писать
        $currentListNode = $emptyListNode; // Конкретный элемент к которму будем дописывать следующий

        while ($list1 !== null && $list2 !== null) {
            if($list1->val > $list2->val) { // Что меньше, то и допишем
                $currentListNode->next = $list2;
                $list2 = $list2->next; // откусим начало списка
            } else {
                $currentListNode->next = $list1;
                $list1 = $list1->next; // откусим начало списка
            }
            $currentListNode = $currentListNode->next; // Продвинем указатель
        }

        // Если в списках что-то осталось, то допишем
        $currentListNode->next = $list1 != null ? $list1 : $list2;

        return $emptyListNode->next; // откусим синтезированное начало и вернём
    }
}

$list1 = new ListNode(1,
         new ListNode(2,
         new ListNode(4, null)));

$list2 = new ListNode(1,
         new ListNode(3,
         new ListNode(4, null)));

var_dump(Solution::mergeTwoLists($list1,$list2));