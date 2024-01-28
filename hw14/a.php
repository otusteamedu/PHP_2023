<?php
/**
 *Сложность O(n)
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $hash=[];
        $i = -1;
        $one=$head;

        while (is_null($one->next)==false && isset($one->next) )
        {
            $hash[$one->next->pos]++;
            if( $hash[$one->next->pos]>1){
                return true;
                break;
            }
            $one=$one->next;

        }

        return false;
    }
}