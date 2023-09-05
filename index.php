<?php

/**
 * Definition for a singly-linked list.
 */
class ListNode
{
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{
    function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {
        $listNode = new ListNode();
        $list = [];

        do {
            if (!is_null($list1->val) && !is_null($list2->val)) {
                if ($list1->val <= $list2->val) {
                    $listNode->val = $list1->val;
                    $listNode->next = new ListNode(null);
                    $list1 = $list1->next;
                } else {
                    $listNode->val = $list2->val;
                    $listNode->next = new ListNode(null);
                    $list2 = $list2->next;
                }

                $list[] = $listNode;

            } elseif (!is_null($list1->val)) {
                $listNode->val = $list1->val;
                $listNode->next = (!is_null($list1->next) || !is_null($list2->next)) ? new ListNode() : null;
                $list1 = $list1->next;
                $list[] = $listNode;

            } elseif (!is_null($list2->val)) {
                $listNode->val = $list2->val;
                $listNode->next = (!is_null($list1->next) || !is_null($list2->next)) ? new ListNode(null) : null;
                $list2 = $list2->next;
                $list[] = $listNode;
            }

            $listNode = $listNode->next ?? $listNode;

        } while ($list1 || $list2);

        return $list[0];
    }
}
