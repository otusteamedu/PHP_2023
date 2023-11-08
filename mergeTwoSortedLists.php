<?php

//Definition for a singly-linked list.
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
    private ?ListNode $lastListValue1;
    private ?ListNode $lastListValue2;

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2): ListNode
    {
        $this->lastListValue1 = $list1;
        $this->lastListValue2 = $list2;
        $finalList = new ListNode(null, null);

        do {
            if (!$finalList->val) {
                $finalList->val = $this->getNext()->val;
            } else {
                $nextValue = $this->getNext();
                $this->setToEnd($finalList, $nextValue);
            }
        } while ($this->lastListValue1 != null || $this->lastListValue2 != null);

        return $finalList;
    }

    function getNext(): ListNode
    {
        if ($this->lastListValue1->val > $this->lastListValue2->val || $this->lastListValue1->val == null) {
            $next = new ListNode($this->lastListValue2->val);
            $this->lastListValue2 = $this->lastListValue2->next ?? null;
        } else {
            $next = new ListNode($this->lastListValue1->val);
            $this->lastListValue1 = $this->lastListValue1->next ?? null;
        }

        return $next;
    }

    function setToEnd(ListNode $updatedList, ListNode $newValue): void
    {
        if ($updatedList->next != null) {
            $this->setToEnd($updatedList->next, $newValue);
        } else {
            $updatedList->next = $newValue;
        }
    }
}

//код для проверки
$list14 = new ListNode(4);
$list12 = new ListNode(2, $list14);
$list11 = new ListNode(1, $list12);

$list24 = new ListNode(4);
$list23 = new ListNode(3, $list24);
$list21 = new ListNode(1, $list23);

$solution = new Solution();

$out = $solution->mergeTwoLists($list11, $list21);

$array = [1, 2, 3];

var_dump($out);
