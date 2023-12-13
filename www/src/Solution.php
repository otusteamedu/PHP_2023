<?php

declare(strict_types=1);

namespace Yalanskiy\Lists;

/**
 * Lists operations
 */
class Solution
{
    /**
     * Merge two sorted lists
     *
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     *
     * @return ListNode|null
     */
    public static function mergeTwoLists(ListNode|null $list1, ListNode|null $list2): ListNode|null
    {
        if ($list1 === null) {
            return $list2;
        }

        if ($list2 === null) {
            return $list1;
        }

        $head = null;
        $currentItem = null;
        while (true) {
            if ($list1 === null && $list2 === null) {
                break;
            }

            if ($list1 === null) {
                $val = $list2->val;
                $list2 = $list2->next;
            } elseif ($list2 === null) {
                $val = $list1->val;
                $list1 = $list1->next;
            } elseif ($list2->val > $list1->val) {
                $val = $list1->val;
                $list1 = $list1->next;
            } else {
                $val = $list2->val;
                $list2 = $list2->next;
            }

            $listItem = new ListNode($val);
            if ($currentItem !== null) {
                $currentItem->next = $listItem;
            }
            if ($head === null) {
                $head = $listItem;
            }
            $currentItem = $listItem;
        }

        return $head;
    }
}
