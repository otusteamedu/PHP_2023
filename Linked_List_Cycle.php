<?php

class ListNode {
    public $val;
    public $next;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {

        if ($head == null || $head->next == null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($slow !== $fast) {
            if ($fast == null || $fast->next == null) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}

// Создаем узлы
$node1 = new ListNode(1);
$node2 = new ListNode(2);
$node3 = new ListNode(3);
$node4 = new ListNode(4);

// Формируем связи
$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node4;
// Создаем цикл: последний узел связываем с первым узлом
$node4->next = $node1;

$solution = new Solution();
// Проверяем наличие цикла
$result = $solution->hasCycle($node1);
echo $result ? "Цикл существует" : "Цикла нет";
