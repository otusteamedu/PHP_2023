<?php

declare(strict_types=1);

namespace Imitronov\Hw14\LinkedListCycle;

/**
 * @link https://leetcode.com/problems/linked-list-cycle/
 */
class Solution
{
    public function hasCycle(ListNode $head): bool
    {
        $cycle = new ListNode(0);

        if (null === $head->next) {
            return false;
        }

        do {
            $next = $head->next;

            if ($next === $cycle) {
                return true;
            }

            $head->next = $cycle;
            $head = $next;
        } while (null !== $next->next);

        return false;
    }
}
