<?php

declare(strict_types=1);

namespace Yalanskiy\LeetCode\LinkedListCycle;

/**
 * Class Solution
 */
class Solution
{
    /**
     * @param ListNode $head
     *
     * @return Boolean
     */
    public static function hasCycle(ListNode $head): bool
    {
        $hash = [];

        while ($head !== null) {
            $objectId = spl_object_id($head);
            if (isset($hash[$objectId])) {
                return true;
            }
            $hash[$objectId] = $head;
            $head = $head->next;
        }

        return false;
    }
}
