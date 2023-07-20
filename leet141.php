/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
 function hasCycle($head) {
        if (empty($head) || empty($head->next)) {
            return false;
        }
        
        $current = $head;
        $next = $head->next;
        
        while ($current !== $next) {
            if (empty($current) || empty($next->next)) {
                return false;
            }
            
            $current = $current->next;
            $next = $next->next->next;
        }
        
        return true; 
    }
}
