<?php

class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    public function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {
    public function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode {
        $start = $currentListNode = new ListNode();

        while ($list1 && $list2) {
            if ($list1->val <= $list2->val) {
                $new = new ListNode($list1->val, null);
                $currentListNode->next = $new;
                $currentListNode = $new;
                $list1 = $list1->next;
            } else {
                $new = new ListNode($list2->val, null);
                $currentListNode->next = $new;
                $currentListNode = $new;
                $list2 = $list2->next;
            }
        }

        if ($list1 || $list2) {
            $currentListNode->next = $list1 ?? $list2;
        }

       return $start->next;
    }
}

// 4 - 2 - 1
$list1 = new ListNode(4);
$list1 = new ListNode(2, $list1);
$list1 = new ListNode(1, $list1);

// 5 - 2 - 1
$list2 = new ListNode(5);
$list2 = new ListNode(2, $list2);
$list2 = new ListNode(1, $list2);

$echoList = (new Solution())->mergeTwoLists($list1, $list2);

while ($echoList) {
    echo $echoList->val . PHP_EOL;
    $echoList = $echoList->next;
}

