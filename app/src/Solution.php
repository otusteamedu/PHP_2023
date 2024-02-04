<?php

namespace Sherweb;

/**
 * Definition for a singly-linked list.
 *
 * Временная сложность этого решения составляет O(m + n), где m и n - длины входных списков list1 и list2 соответственно.
 * Это потому, что нам нужно пройти по каждому списку только один раз, чтобы их объединить.
 *
 * Сложность по памяти данного решения составляет O(1).
 * Количество использованных переменных фиксировано и не зависит от объема переданных данных
 */
class Solution
{
    /**
     * Merge two sorted linked lists.
     * @param ListNode|null $l1
     * @param ListNode|null $l2
     * @return ListNode
     */
    function mergeTwoLists(?ListNode $l1, ?ListNode $l2): ?ListNode
    {
        $dummy = new ListNode(0);
        $current = $dummy;

        while ($l1 != null && $l2 != null) {
            if ($l1->val < $l2->val) {
                $current->next = $l1;
                $l1 = $l1->next;
            } else {
                $current->next = $l2;
                $l2 = $l2->next;
            }
            $current = $current->next;
        }

        if ($l1 != null) {
            $current->next = $l1;
        } else {
            $current->next = $l2;
        }

        return $dummy->next;
    }
}