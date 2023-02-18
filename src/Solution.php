<?php

declare(strict_types=1);

namespace Twent\Hw6;

final class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if (!$list1) {
            return $list2;
        }

        if (!$list2) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $list1->next = $this->mergeTwoLists($list1->next, $list2);
            return $list1;
        }

        $list2->next = $this->mergeTwoLists($list2->next, $list1);
        return $list2;
    }
}
