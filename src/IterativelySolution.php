<?php

declare(strict_types=1);

namespace Twent\Hw6;

final class IterativelySolution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if (! $list1) {
            return $list2;
        }

        if (! $list2) {
            return $list1;
        }

        $mergedList = new ListNode();
        $current = $mergedList;

        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }

            $current = $current->next;
        }

        if ($list1) {
            $current->next = $list1;
        }

        if ($list2) {
            $current->next = $list2;
        }

        return $mergedList->next;
    }
}
