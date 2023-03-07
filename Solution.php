<?php

namespace App;

/**
 * Definition for a singly-linked list.
 *
 * class ListNode
 * {
 *     public $val = 0;
 *     public $next = null;
 *
 *     public function __construct($val = 0, $next = null)
 *     {
 *         $this->val  = $val;
 *         $this->next = $next;
 *     }
 * }
 *
 */

class Solution
{
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        $dummy = new ListNode();
        $tail  = $dummy;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $tail->next = $list1;
                $list1      = $list1->next;
            } else {
                $tail->next = $list2;
                $list2      = $list2->next;
            }

            $tail = $tail->next;
        }

        if ($list1) {
            $tail->next = $list1;
        } elseif ($list2) {
            $tail->next = $list2;
        }

        return $dummy->next;
    }
}
