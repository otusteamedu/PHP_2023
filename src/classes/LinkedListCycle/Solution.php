<?php

namespace Klobkovsky\App\LinkedListCycle;

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public static function hasCycle($head)
    {
        $visitedNodes = [];
        $currentNode = $head;

        while ($currentNode !== null) {
            if (in_array($currentNode, $visitedNodes)) {
                return true;
            }

            $visitedNodes[] = $currentNode;
            $currentNode = $currentNode->next;
        }

        return false;
    }
}
