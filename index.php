<?php

include __DIR__ . '/vendor/autoload.php';

/**
 * @param ListNode $list1
 * @param ListNode $list2
 * @return ListNode
 */
function mergeTwoLists($list1, $list2) {
    $head = new ListNode();
    $headStart = $head;

    while (true) {
        if ($list1->val < $list2->val) {
            $head->val = $list1->val;
            $list1 = $list1->next;
        } else {
            $head->val = $list2->val;
            $list2 = $list2->next;
        }

        if ($list1 === null) {
            $head->next = $list2;
            break;
        }

        if ($list2 === null) {
            $head->next = $list1;
            break;
        }

        $head->next = new ListNode();
        $head = $head->next;
    }

    return $headStart;
}
