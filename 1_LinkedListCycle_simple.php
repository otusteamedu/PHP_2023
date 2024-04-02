<?php

// Definition for a singly-linked list.
class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val) { $this->val = $val; }
}

class Solution
{
    /**
     * @param ListNode $head
     * @return bool
     */
    function hasCycle($head) {
        $hash = [];
        $currentNode = $head;
        // Получаем числовой id текущего узла
        $nodeId = spl_object_id($currentNode);

        // Пока в хэше не найден id - продолжаем
        while (!array_key_exists($nodeId, $hash)) {
            // Добавляем id в хэш
            $hash[$nodeId] = true;
            // Если это конец цепочки - возвращаем false
            if ($currentNode->next === null) {
                return false;
            }
            // Получаем следующий узел
            $currentNode = $currentNode->next;
            // Получаем id нового узла
            $nodeId = spl_object_id($currentNode);
        }

        // Если вышли из цикла - значит нашли цикличность
        return true;
    }
}
