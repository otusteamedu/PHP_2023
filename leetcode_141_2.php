<?php

declare(strict_types=1);

namespace Vp;

/**
 * Hashmap method (1) implementation
 *
 * Runtime 472 ms
 */
class SolutionTwo
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
            if (in_array($head, $hash, true)) {
                $pos = array_search($head, $hash, true);
                break;
            }

            $hash[] = $head;
            $head = $head->next;
        }

        return !($pos < 0);
    }
}
