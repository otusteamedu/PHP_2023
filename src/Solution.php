<?php

declare(strict_types=1);

namespace App;

final class Solution
{
    public static function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        $result = new ListNode();
        $temp = $result;

        while ($list1 && $list2) {
            if ($list1->val < $list2->val) {
                $temp->next = new ListNode($list1->val);
                $list1 = $list1->next;
            } elseif ($list1->val > $list2->val) {
                $temp->next = new ListNode($list2->val);
                $list2 = $list2->next;
            } else {
                $temp->next = new ListNode($list1->val, new ListNode($list2->val));
                $list1 = $list1->next;
                $list2 = $list2->next;
                $temp = $temp->next;
            }

            $temp = $temp->next;
        }

        $temp->next = $list1 ?: $list2;

        return $result->next;
    }
}
