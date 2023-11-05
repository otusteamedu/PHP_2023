<?php

namespace src;

class Solution141
{
    /**
     * @param ListNode141 $head
     * @return Boolean
     */
    function hasCycle($head): bool
    {
        if (is_null($head)) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;
        while ($slow !== $fast) {
            if (is_null($fast) || is_null($fast->next)) {
                return false;
            }
            $slow = $slow->next;
            $fast = $fast->next->next;
        }
        return true;
    }
}