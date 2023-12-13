<?php


/**
 * Class ListNode
 *
 * Definition for a singly-linked list.
 */
  class ListNode {
      public $val = 0;
      public $next = null;
      function __construct($val = 0, $next = null) {
          $this->val = $val;
          $this->next = $next;
      }
  }

class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        // Create a sentinel node to act as the start of the merged list
        $sentinel = new ListNode(0);
        $current = $sentinel;

        // Traverse both lists and append the smaller value to the merged list
        while ($list1 !== null && $list2 !== null) {
            if ($list1->val < $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }

        // Append any remaining elements from either list to the merged list
        if ($list1 !== null) {
            $current->next = $list1;
        } elseif ($list2 !== null) {
            $current->next = $list2;
        }

        // The merged list starts after the sentinel node
        return $sentinel->next;
    }
}
