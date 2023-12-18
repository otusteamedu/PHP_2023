<?php

declare(strict_types=1);

namespace Agrechuha\Otus;

class Solution
{
    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     *
     * @return ListNode|null
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        if (!$list1) {
            return $list2;
        }

        if (!$list2) {
            return $list1;
        }

        $resultListHead        = null;
        $currentNodeResultList = null;
        $currentNodeList1      = $list1;
        $currentNodeList2      = $list2;

        while ($currentNodeList1 || $currentNodeList2) {
            if (!$resultListHead) {
                if ($currentNodeList1->val < $currentNodeList2->val) {
                    $resultListHead   = new ListNode($currentNodeList1->val);
                    $currentNodeList1 = $currentNodeList1->next;
                } else {
                    $resultListHead   = new ListNode($currentNodeList2->val);
                    $currentNodeList2 = $currentNodeList2->next;
                }

                $currentNodeResultList = $resultListHead;
            }

            if (!$currentNodeList1) {
                $currentNodeResultList->next = $currentNodeList2;
                break;
            } elseif (!$currentNodeList2) {
                $currentNodeResultList->next = $currentNodeList1;
                break;
            }

            if ($currentNodeList1->val < $currentNodeList2->val) {
                $currentNodeResultList->next = new ListNode($currentNodeList1->val);
                $currentNodeList1            = $currentNodeList1->next;
            } else {
                $currentNodeResultList->next = new ListNode($currentNodeList2->val);
                $currentNodeList2            = $currentNodeList2->next;
            }

            $currentNodeResultList = $currentNodeResultList->next;
        }

        return $resultListHead;
    }
}
