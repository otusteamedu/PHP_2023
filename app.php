<?php

final class ListNode {
    public int $val = 0;
    public ?ListNode $next = null;
    public function __construct(int $val = 0, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
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

$first = new ListNode(0, new ListNode(1, new ListNode(2, new ListNode(3))));
$second = new ListNode(0, new ListNode(1, new ListNode(3, new ListNode(5))));

$lists = mergeTwoLists($first, $second);

print_r($lists);
