<?php

namespace Leetcode;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head): bool
    {
        $hash = [];
        while ($head !== null) {
            if ($hash[spl_object_hash($head)]) {
                return true;
            }
            $hash[spl_object_hash($head)] = true;
            $head = $head->next;
        }

        return false;
    }
}
