<?php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Lists {
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists(ListNode $list1, ListNode $list2) : ?ListNode {
        $current = new ListNode();
        $mergedList = $current;
        while (isset($list1, $list2)) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }
        $current->next = $list1 ?? $list2;
        return $mergedList->next;
    }
}

$list1 = new ListNode(4);
$list1 = new ListNode(2, $list1);
$list1 = new ListNode(1, $list1);

$list2 = new ListNode(4);
$list2 = new ListNode(3, $list2);
$list2 = new ListNode(1, $list2);

$lists = new Lists();
$result = $lists->mergeTwoLists($list1, $list2);

while($result){
    echo $result->val . PHP_EOL;
    $result = $result->next;
}


