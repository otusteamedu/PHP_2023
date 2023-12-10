<?php

declare(strict_types=1);

use Alexchugun\App;

class Solution
{
    function mergeTwoLists($list1, $list2)
    {
        $list = new ListNode();
        $current = $list;

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
        }

        if ($list2 !== null) {
            $current->next = $list2;
        }

        return $list->next;
    }
}
