<?php

declare(strict_types=1);

namespace Vp;

/**
 * Floyd's method implementation
 *
 * Runtime 17 ms
 */
class SolutionOne
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $slow = $head;
        $fast = $head;
        $flag = false;

        while ($slow != null && $fast != null && $fast->next != null) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            if ($slow === $fast) {
                $flag = true;
                break;
            }
        }

        return $flag;
    }
}
