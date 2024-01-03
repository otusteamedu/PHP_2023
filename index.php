<?php

declare(strict_types=1);

use Chernomordov\App\ListNode;

class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        $head = $tail = new ListNode();
        while (isset($list1, $list2)) {
            if ($list1->val < $list2->val) {
                $tail->next = $list1;
                $list1 = $list1->next;
            } else {
                $tail->next = $list2;
                $list2 = $list2->next;
            }
            $tail = $tail->next;
        }
        $tail->next = $list1 ?? $list2;
        return $head->next;
    }
}
