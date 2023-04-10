<?php

declare(strict_types=1);

namespace Vp;

/**
 * Hashmap method (2) implementation
 *
 * Runtime 22 ms
 */
class SolutionThree
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $hash = [];
        $pos = -1;

        while ($head != null) {
            $pos++;
            $objectId = spl_object_hash($head);
            if (isset($hash[$objectId])) {
                return true;
            }

            $hash[$objectId] = $pos;
            $head = $head->next;
        }

        return false;
    }
}
