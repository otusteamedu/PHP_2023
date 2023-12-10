<?php

use Rvoznyi\ComposerHello\ListNode;

/**
 * @param ListNode $l1
 * @param ListNode $l2
 * @return ListNode|null
 */
function mergeTwoLists(ListNode $l1, ListNode $l2): ?ListNode
{
    $dummy = new ListNode();
    $current = $dummy;

    while ($l1 !== null && $l2 !== null) {
        if ($l1->val < $l2->val) {
            $current->next = $l1;
            $l1 = $l1->next;
        } else {
            $current->next = $l2;
            $l2 = $l2->next;
        }
        $current = $current->next;
    }
    if ($l1 !== null) {
        $current->next = $l1;
    } elseif ($l2 !== null) {
        $current->next = $l2;
    }
    return $dummy->next;
}
