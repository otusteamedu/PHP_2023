<?php

/**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
 */
function mergeTwoLists($list1, $list2)
{
    $out = new ListNode();
    $temp = $out;
    while ($list1->val !== null && $list2->val !== null) {
        if ($list1->val <= $list2->val) {
            $temp->next = new ListNode($list1->val);
            $list1 = $list1->next;
        } else {
            $temp->next = new ListNode($list2->val);
            $list2 = $list2->next;
        }
        $temp = $temp->next;
    }
    $temp->next = $list1 ? $list1 : $list2;
    $temp = $temp->next;
    return $out->next;
}
