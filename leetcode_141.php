<?php

declare(strict_types=1);

/**
 * Floyd's method implementation
 *
 * Runtime 17 ms
 */
class SolutionOne {
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

/**
 * Hashmap method (1) implementation
 *
 * Runtime 472 ms
 */
class SolutionTwo {
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

/**
 * Hashmap method (2) implementation
 *
 * Runtime 22 ms
 */
class SolutionThree {
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
