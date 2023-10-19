<?php
/
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $counter = 0;
        if ($this->stepNext($head, $counter) > 10000) {
            return true;
        } else {
            return false;
        }
    }

    function stepNext($node, $counter) {
        if ($counter > 10000) {
            return $counter;
        } elseif ($node->next == null) {
            return $counter;
        } else {
            return $this->stepNext($node->next, $counter + 1);
        }
    }
}

?>