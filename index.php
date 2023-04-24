<?php

class ListNode
{
    public ?int $val = 0;
    public ?self $next = null;

    function __construct(?int $val = 0, self $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

$list1 = new ListNode(1, new  ListNode(2, new  ListNode(4)));
$list2 = new ListNode(1, new  ListNode(3, new  ListNode(4)));

$list3 = new ListNode(null);
$list4 = new ListNode(null);

$list5 = new ListNode(null);
$list6 = new ListNode();

class Solution
{

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists(ListNode $list1, ListNode $list2): ListNode
    {

        $list3 = new ListNode(null, null);
        $prev = $list3;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $prev->next = $list1;
                $list1 = $list1->next;
            } else {
                $prev->next = $list2;
                $list2 = $list2->next;
            }
            $prev = $prev->next;
        }

        if ($list1 === null) {
            $prev->next = $list2;
        }

        if ($list2 === null) {
            $prev->next = $list1;
        }

        return $list3->next;
    }

}

var_dump((new Solution())->mergeTwoLists($list1, $list2));

var_dump((new Solution())->mergeTwoLists($list3, $list4));

var_dump((new Solution())->mergeTwoLists($list5, $list6));
