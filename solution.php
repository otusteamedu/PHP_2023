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

// Сложность по времени: O(n) - время выполнения зависит от количества элементов в переданных списках
// Сложность по памяти: O(1) - Количество использованных переменных фиексировано и не зависит от объема переданных данных

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        // Создаем "заглушку" для начала нового списка.
        $thread = new ListNode();
        // Устанавливаем 'pearl', как текущий элемент в новом списке.
        $pearl = $thread;

        while (isset($list1) && isset($list2)) {
            // Сравниваем значения в начале каждого списка и выбираем меньший или равный.
            // Передаем его в переменную $lower по ссылке
            if ($list1->val <= $list2->val) {
                $lower = &$list1;
            } else {
                $lower = &$list2;
            }
            // Добавляем выбранный элемент в новый список.
            $pearl->next = $lower;
            // Обновляем текущий элемент в новом списке.
            $pearl = $lower;
            // Перемещаем указатель в выбранном списке на следующий элемент.
            $lower = $lower->next;
        }

        // Если остались элементы в одном из списков,
        // добавляем оставшиеся элементы к новому списку.
        $pearl->next = $list1 ?? $list2;

        // Возвращаем объединенный отсортированный список, исключая заглушку в начале.
        return $thread->next;
    }
}
