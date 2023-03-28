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
        return null;
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
