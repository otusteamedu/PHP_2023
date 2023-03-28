<?php

declare(strict_types=1);

namespace Aporivaev\Hw08;

class Solution
{
    /**
     * @param ?ListNode $list1
     * @param ?ListNode $list2
     * @return ?ListNode
     */
    public function mergeTwoLists(?ListNode $list1 = null, ?ListNode $list2 = null): ?ListNode
    {
        if ($list1 === null) {
            return $list2;
        }
        if ($list2 === null) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $head = $list1;
            $list1 = $list1->next;
        } else {
            $head = $list2;
            $list2 = $list2->next;
        }
        $cur = $head;

        while ($list1 != null && $list2 != null) {
            if ($list1->val < $list2->val) {
                $cur->next = $list1;
                $list1 = $list1->next;
            } else {
                $cur->next = $list2;
                $list2 = $list2->next;
            }
            $cur = $cur->next;
        }

        if ($list1 != null) {
            $cur->next = $list1;
        }
        if ($list2 != null) {
            $cur->next = $list2;
        }

        return $head;
    }

    public function compareLists(?ListNode $list1 = null, ?ListNode $list2 = null): bool
    {
        while ($list1 !== null && $list2 !== null) {
            if ($list1->val !== $list2->val) {
                return false;
            }
            $list1 = $list1->next;
            $list2 = $list2->next;
        }
        return ($list1 === null && $list2 === null);
    }
    public function toStringLists(?ListNode $list = null): string
    {
        if ($list === null) {
            return 'null';
        }

        $arr = [];
        while ($list !== null) {
            $arr[] = $list->val;
            $list = $list->next;
        }
        return implode(', ', $arr);
    }
}
