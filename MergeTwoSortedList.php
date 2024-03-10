<?php

declare(strict_types=1);
/**
 * Definition for a singly-linked list.
 */
class ListNode {
    public int $val = 0;
    public ?self $next = null;
    function __construct(int $val = 0, ?self $next = null) {
    $this->val = $val;
    $this->next = $next;
    }
}

class Solution {

    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode|null
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode {
        if (!$list1 && !$list2) {
            return null;
        }

        if ($list1 === null) {
            return $list2;
        }

        if ($list2 === null) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $newHead = $list1;
            $list1 = $list1->next;
        } else {
            $newHead = $list2;
            $list2 = $list2->next;
        }

        $newHead->next = $this->mergeTwoLists($list1, $list2);
        return $newHead;
    }
}