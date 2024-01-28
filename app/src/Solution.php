<?php

namespace Sherweb;

/**
 * Definition for a singly-linked list.
 */
class Solution
{
    /**
     * Merge two sorted linked lists.
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function mergeTwoLists(ListNode $l1, ListNode $l2): ListNode
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