<?php

declare(strict_types=1);

namespace DOlshev\Hw;

class MergeTwoSortedLists
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ListNode | null
    {
        if ($list1 == null) {
            return $list2;
        } else if ($list2 == null) {
            return $list1;
        }

        $result = new ListNode();
        if ($list1->val <= $list2->val) {
            $result = $list1;
            $result->next = $this->mergeTwoLists($list1->next, $list2);
        } else {
            $result = $list2;
            $result->next = $this->mergeTwoLists($list1, $list2->next);
        }

        return $result;
    }
}
