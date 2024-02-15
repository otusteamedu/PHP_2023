<?php

// Сложность этого алгоритма можно объяснить следующим образом:
// Проходим по связанному списку только один раз.
// В каждой итерации цикла мы сдвигаем медленный указатель на один элемент и быстрый указатель на два элемента.
// Если цикл есть в списке, то наш алгоритм гарантированно обнаружит его за время, пропорциональное количеству элементов в цикле.
// Поэтому временная сложность данного алгоритма O(n), где n - количество элементов в списке. Он зависит линейно от размера входных данных.

class MyListNode {
    public $val = 0;
    public $next = null;

    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {
    function hasCycle($head) {
        if ($head == null || $head->next == null) {
            return false;
        }
        
        $slow = $head;
        $fast = $head;
        
        while ($fast != null && $fast->next != null) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            
            if ($slow === $fast) {
                return true; // Найден цикл
            }
        }
        
        return false; // Цикл не найден
    }
}

// Пример использования:
$head = new MyListNode(3);
$head->next = new MyListNode(2);
$head->next->next = new MyListNode(0);
$head->next->next->next = new MyListNode(-4);
$head->next->next->next->next = $head->next; // Делаем цикл: -4 -> 2

$solution = new Solution();
var_dump($solution->hasCycle($head)); // Вернет true

