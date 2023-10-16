<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2)
    {
        $result = null;

        if ($list1 == null) return $list2;
        if ($list2 == null) return $list1;

        if ($list1->val <= $list2->val) {
            $result = $list1;
            $result->next = $this->mergeTwoLists($list1->next, $list2);
        } else {
            $result = $list2;
            $result->next = $this->mergeTwoLists($list1, $list2->next);
        }

        return $result;
    }
}

/**
 * Алгоритмическая сложность: линейная сложность, так как при увеличении количества элементов в списках
 * скорость алгоритма прямо пропорционально снижается
 */

