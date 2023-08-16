<?php

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

/**
 * @param ListNode $list1
 * @param ListNode $list2
 * @return ListNode
 */
function mergeTwoLists($list1, $list2)
{
    if ($list1 === null) {
        return $list2;
    }
    if ($list2 === null) {
        return $list1;
    }

    $res = new ListNode(0);
    $current = $res;

    while ($list1 || $list2) {
        if ($list1 !== null && ($list2 === null || $list1->val <= $list2->val)) {
            $current->next = new ListNode($list1->val);
            $list1 = $list1->next;
        } else {
            $current->next = new ListNode($list2->val);
            $list2 = $list2->next;
        }
        $current = $current->next;
    }
    return $res->next;
}

print_r(
    mergeTwoLists(
        new ListNode(2),
        new ListNode(1),
    ),
);

print_r(
    mergeTwoLists(
        new ListNode(1, new ListNode(2, new ListNode(4))),
        new ListNode(1, new ListNode(3, new ListNode(4))),
    ),
);