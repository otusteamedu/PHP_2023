<?php

declare(strict_types=1);

namespace App\LinkedListCycle;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
    {
        $slow = $head;
        $fast = $head;

        while ($fast !== null && $fast->next !== null) {
            $slow = $slow->next;
            $fast = $fast->next->next;

            if ($slow === $fast) {
                return true; // Cycle detected
            }
        }

        return false; // No cycle found
    }
}


// Алгоритмическая сложность - O(n). Время выполнения алгоритма линейно зависит
// от количества элементов в списке.
