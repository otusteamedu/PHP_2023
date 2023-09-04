<?php

 /**
 * Сложность этой задачи можно оценить как O(M + N), где M - длина одного связанного списка, а N - длина другого связанного списка.
 */

namespace Leetcode;

class Solution
{
    public function getIntersectionNode($headA, $headB)
    {
        $lenA = $this->getLength($headA);
        $lenB = $this->getLength($headB);

        $ptrA = $headA;
        $ptrB = $headB;

        // Сдвигаем указатель длинного списка на разницу в длинах
        if ($lenA > $lenB) {
            for ($i = 0; $i < ($lenA - $lenB); $i++) {
                $ptrA = $ptrA->next;
            }
        } elseif ($lenB > $lenA) {
            for ($i = 0; $i < ($lenB - $lenA); $i++) {
                $ptrB = $ptrB->next;
            }
        }

        // Перемещаем указатели по обоим спискам до пересечения
        while ($ptrA !== $ptrB) {
            $ptrA = $ptrA->next;
            $ptrB = $ptrB->next;
        }

        return $ptrA; // Возвращаем узел пересечения (или null, если их нет)
    }

    private function getLength($head)
    {
        $length = 0;
        $current = $head;
        while ($current !== null) {
            $length++;
            $current = $current->next;
        }
        return $length;
    }
}
