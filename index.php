/
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    /
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        if ($list1 == null) {
            return $list2;
        }
        if ($list2 == null) {
            return $list1;
        }

        if ($list1->val < $list2->val) {
            $current = $list1;
            $head = $current;
            $another = $list2;
        } else {
            $current = $list2;
            $head = $current;
            $another = $list1;
        }
        
        while ($current->next != null && $another != null) {
            if ($current->next->val < $another->val) {
                $current = $current->next;
            } else {
                $temp = $current->next;
                $current->next = $another;
                $current = $another;
                $another = $temp;
            }
        }

        $current->next = $another;
        
        return $head;        
    }
}