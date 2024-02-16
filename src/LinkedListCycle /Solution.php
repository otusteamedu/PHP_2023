<?php
declare(strict_types=1);

namespace WorkingCode\Hw14\LinkedListCycle;

class Solution
{
    public function hasCycle(ListNode $head): bool
    {
        $hash = [];

        while ($head->next !== null) {
            if (isset($hash[spl_object_id($head)])) {
                return true;
            }

            $hash[spl_object_id($head)] = true;
            $head                       = $head->next;

        }

        return false;
    }
}
