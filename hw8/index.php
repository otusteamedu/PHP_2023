<?php
declare(strict_types=1);
function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode {
    $node = new ListNode(0);
    $current = $node;
    while ($list1 !== null && $list2 !== null) {
        if ($list1->val < $list2->val) {
            $current->next = $list1;
            $list1 = $list1->next;
        } else {
            $current->next = $list2;
            $list2 = $list2->next;
        }

        $current = $current->next;
    }

    if ($list1 !== null) {
        $current->next = $list1;
    } elseif ($list2 !== null) {
        $current->next = $list2;
    }

    return $node->next;
}
