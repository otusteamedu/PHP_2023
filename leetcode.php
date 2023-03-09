<?php

declare(strict_types=1);

namespace Vp;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(ListNode $list1, ListNode $list2)
    {
        $list3 = new ListNode();
        $tmpNode = $list3;

        while (($list1 != null) || ($list2 != null)) {
            if (($list1 == null) && ($list2 != null)) {
                $tmpNode->next = $list2;
                break;
            }

            if (($list2 == null) && ($list1 != null)) {
                $tmpNode->next = $list1;
                break;
            }

            if ($list1->val <= $list2->val) {
                $tmpNode->next = $list1;
                $list1 = $list1->next;
            } else {
                $tmpNode->next = $list2;
                $list2 = $list2->next;
            }

            $tmpNode = $tmpNode->next;
            $tmpNode->next = $list1 ?? $list2;
        }

        return $list3->next;
    }
}
